<?php

namespace App\Http\Controllers;

use App\Jobs\ImportPostJob;
use App\Models\User;
use Botble\Ecommerce\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Botble\Ecommerce\Models\Customer;
use Botble\Ecommerce\Models\Agent;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Models\ProductTag;
use Botble\Ecommerce\Models\Regione;
use Botble\Ecommerce\Models\Offers;
use Botble\Ecommerce\Models\OffersDetail;
use Botble\Ecommerce\Models\offerType;
use Botble\Ecommerce\Models\PriceList;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Jobs\OfferDeactivationJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use LDAP\Result;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Response;
use Throwable;


class CustomImportController extends BaseController
{

    public function importUser()
    {
//        dd('ok');
        $users = DB::connection('mysql2')->table('wp_users')->get();
        try {
            DB::transaction(function () use ($users) {
                foreach ($users as $user) {
                    $row = DB::connection('mysql')->table('users')->updateOrInsert(
                        [
                            'email' => $user->user_email,
                        ], [
                            'first_name' => $user->user_nicename,
                            'email' => $user->user_email,
                            'password' => bcrypt('12345678'),
                            'email_verified_at' => now(),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            });
        } catch (Throwable $e) {
            dd($e);
        }
    }

    public function importPost()
    {
        $posts = collect(DB::connection('mysql2')->table('wp_posts')->get())->map(function ($item) {
            return (array)$item;
        });
        $authors = collect(DB::connection('mysql2')->table('wp_users')->whereIn('id', $posts->pluck('post_author')->unique()->toArray())->get())->map(function ($item) {
            return (array)$item;
        })->pluck('user_email', 'ID')->toArray();

        try {
            DB::transaction(function () use ($authors, $posts) {
                $i=1;
                foreach ($posts as $post) {
                    $post_url="https://www.gochange.it/business/aaa/".$this->post['ID'];
                    if ($this->file_contents_exist($post_url)){
                        $fp = file_get_contents($post_url);
                        $tags = [];
                        preg_match_all('/<img.+?class=".*?attachment-single-thumb size-single-thumb wp-post-image.*?"/', $fp, $tags);
                        $url = collect($tags)->flatten()->map(function ($item) {
                            preg_match('/<img(.*)src(.*)=(.*)"(.*)"/U', $item, $images);
                            return array_pop($images);
                        })->filter(function ($item) {
                            return filter_var($item, FILTER_VALIDATE_URL);
                        })->last();
                        if ($url && strlen($url) && $this->file_contents_exist($url)) {
                            dump($post_url,$url);
                        }
                    }
//                    ImportPostJob::dispatch($post,$authors,Str::slug($post['post_title'])."-".$i);
                    $i++;
                }
            });
        } catch (Throwable $e) {
            dd($e);
        }
    }

    function file_contents_exist($url, $response_code = 200)
    {
        $headers = get_headers($url);

        if (substr($headers[0], 9, 3) == $response_code) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function brands()
    {
        $brands = DB::connection('mysql2')->select('select * from acq_fornitore');
        $brands_updated = array();
        foreach ($brands as $brand) {
            $row = DB::connection('mysql')->table('ec_brands')->updateOrInsert(
                [
                    'id' => $brand->pk_fornitore_id,
                    'name' => $brand->nome,
                ]
                ,
                [
                    'status' => 'published',
                    'order' => '0',
                ]
            );

            array_push($brands_updated, $row);

        }
        if (empty($brands_updated)) return 'No brands record updated';
        else return $brands_updated;
    }

    public function getCreateView()
    {
        page_title()->setTitle('Creare offerte');
        return view('plugins/ecommerce::offerte.create');
    }


    public function getSpedizioneView()
    {
        page_title()->setTitle('Config spedizione');
        $spedizione = DB::select("SELECT * FROM config_spedizione");
        $spedizione = $spedizione[0];
        return view('plugins/ecommerce::spedizione.view', compact('spedizione'));
    }

    public function createOfferView()
    {
        page_title()->setTitle('Shipping offer creation');
        return view('plugins/ecommerce::spedizione.create-offer');
    }


    public function spedizioneUpdate(Request $request)
    {
        $request->validate([
            'min_order' => 'required|numeric|min:0',
            'contribution_lower_order' => 'required|numeric|min:0',
            'supplement_over_50kg' => 'required|numeric|min:0',
            'order_600' => 'required|numeric|min:0|max:1000',
            'order_below_600' => 'required|numeric|min:0|max:1000',
        ]);

        DB::update("UPDATE config_spedizione SET min_order = ? , contribution_lower_order = ? , order_600 = ? , order_below_600 = ? , supplement_over_50kg = ?  WHERE id = 0", [$request->min_order, $request->contribution_lower_order, $request->order_600, $request->order_below_600, $request->supplement_over_50kg]);

        $spedizione = DB::select("SELECT * FROM config_spedizione");
        $spedizione = $spedizione[0];
        return redirect()->route('admin.ecommerce.spedizione.view');


    }


    public function updateExpirationDate(Request $request)
    {
        $offerId = $request->input('offer_id');
        $newDate = $request->input('expiration_date');

        $offer = Offers::findOrFail($offerId);
        $offer->offer_expiring_date = $newDate;
        $offer->save();

        return response()->json(['message' => 'Date updated successfully']);
    }


    public function exportOffer()
    {
        try {
            return DB::transaction(function () {
                $items = \Botble\Ecommerce\Models\Offers::all();
                foreach ($items as $item) {
                    $offerDetails = $item->offerDetails;
                    $item = collect($item)
                        ->put('u_id', $item->id)
                        ->forget(['id', 'offer_details'])
                        ->mapWithKeys(function ($item, $key) {
                            if (str_ends_with($key, '_at')) {
                                $item = date('Y-m-d H:i:s', strtotime($item));
                            } elseif (is_object($item) && method_exists($item, 'getValue')) {
                                $item = $item->getValue();
                            } elseif (is_array($item)) {
                                $item = collect($item)->toJson();
                            }
                            return [$key => $item];
                        })->toArray();
                    DB::connection('mysql2')
                        ->table('ec_offers')
                        ->updateOrInsert([
                            'u_id' => $item['u_id'],
                        ], $item);
                    if ($offerDetails->count()) {
                        foreach ($offerDetails as $offerDetail) {
                            DB::connection('mysql2')
                                ->table('ec_offer_details')
                                ->updateOrInsert([
                                    'u_id' => $offerDetail->id,
                                ], collect($offerDetail)
                                    ->put('u_id', $offerDetail->id)
                                    ->forget(['id', 'offer_details'])
                                    ->mapWithKeys(function ($item, $key) {
                                        if (str_ends_with($key, '_at')) {
                                            $item = date('Y-m-d H:i:s', strtotime($item));
                                        } elseif (is_object($item) && method_exists($item, 'getValue')) {
                                            $item = $item->getValue();
                                        }
                                        return [$key => $item];
                                    })->toArray());
                        }
                    }
                }
                return redirect()->back()->with(['success' => "success"]);
            });
        } catch (Throwable $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => "error"]);
        }

    }


    public function getListView()
    {
        page_title()->setTitle('Elenco delle offerte');
        $offers = Offers::with('offerDetails')->get();
        return view('plugins/ecommerce::offerte.list', compact('offers'));
    }

    public function getCustomersByConsumabili(Request $request)
    {


        $consumabili = $request->input('consumabili');
        $customers = [];
        if ($request->input('scontorange')) {

            $id = intval($consumabili['id']);
            $max = number_format((float)$consumabili['max'], 4, '.', '');
            $min = number_format((float)$consumabili['min'], 4, '.', '');
            $records = DB::connection('mysql')->select("select * from ec_pricelist where (final_price < $max and final_price > $min) and product_id = $id");
            $ids = array_column($records, 'customer_id');
            $incustomers[] = $ids;
        } else {
            foreach ($consumabili as $cs) {
                $cs = intval($cs);
                $records = DB::connection('mysql')->select("select * from ec_pricelist where product_id = $cs");
                $ids = array_column($records, 'customer_id');
                $incustomers[] = $ids;

            }
        }


        $incustomers = array_reduce($incustomers, function ($carry, $array) {
            if ($carry === null) {
                return $array;
            }
            return array_intersect($carry, $array);
        });
        $customers = [];
        $regione_ids = [];
        $agents_ids = [];
        foreach ($incustomers as $id) {
            $record = Customer::find($id);
            if ($record != null) {
                $regione_ids[] = $record->region_id;
                $agents_ids[] = $record->agent_id;
                $customers[] = $record;
            }
        }
        $agents_ids = array_unique($agents_ids);
        $regione_ids = array_unique($regione_ids);

        $regione = [];
        $agents = [];
        foreach ($agents_ids as $agent_id) {
            $record = Agent::find($agent_id);
            if ($record != null) {
                $agents[] = $record;
            }
        }


        foreach ($regione_ids as $regione_id) {
            $record = Regione::find($regione_id);
            if ($record != null) {
                $regione[] = $record;

            }
        }
        $strumenti = [];
        foreach ($customers as $customer) {
            $id = $customer->id;
            $records = DB::connection('mysql')->select("select * from ec_customer_strument where customer_id = $id");
            $tag_ids = array_column($records, 'tag_id');
            $strumenti_tmp = [];
            foreach ($tag_ids as $tag_id) {
                $product = Product::where('sku', $tag_id)->first();
                $strumenti_tmp[] = $product;
            }
            foreach ($strumenti_tmp as $tmp) {
                $id = $tmp->id;
                $strumenti[] = ProductTag::find($id);
            }
        }
        $strumenti = collect($strumenti)->unique('id')->values()->all();

        $data = [
            'incustomers' => $this->array_sort_by_column($customers, 'name'),
            'regione' => $this->array_sort_by_column($regione, 'name'),
            'strumenti' => $this->array_sort_by_column($strumenti, 'name'),
            'agents' => $this->array_sort_by_column($agents, 'nome'),
            'count' => count($customers)
        ];
        return $data;


    }


    private function array_sort_by_column(&$array, $column, $direction = SORT_ASC)
    {
        $reference_array = array();

        foreach ($array as $key => $row) {
            $reference_array[$key] = $row[$column];
        }

        array_multisort($reference_array, $direction, $array);
        return $array;
    }

    public function filterCustomers(Request $request)
    {
        // $customers=$request->input('customers');
        // $query="select * from ec_customers where ";
        // foreach($customers as $customer){
        //     $query.=" id = '".$customer."' or";
        // }
        // $query = rtrim($query, " or");
        // $customers=DB::connection('mysql')->select($query);


        $consumabili = $request->input('consumabili');
        $customers = [];


        foreach ($consumabili as $cs) {
            $ids = DB::table('ec_pricelist')->where('product_id', $cs)->pluck('customer_id')->toArray();
            $incustomers[] = $ids;
        }
        // $incustomers[0] is all we have

        $agents = $request->input('agents');
        $regione = $request->input('regions');
        $strumenti = $request->input('strumenti');

        $strumenti = array_filter($strumenti);
        $regione = array_filter($regione);
        $agents = array_filter($agents);
        $customers = array_filter($customers);


        $filteredCustomerIDsByDate = [];
        $fromDate = Carbon::parse($request->input('fromDate'));
        $toDate = Carbon::parse($request->input('toDate'));
        if ($fromDate && $toDate) {
            $oldProducts = DB::connection('mysql2')->select(
                "select * from cli_acquistato where data between :fromDate and :toDate",
                ['fromDate' => $fromDate, 'toDate' => $toDate]
            );

            $filteredCustomerIDsByDate = array_map(function ($product) {
                return $product->fk_cliente_id;
            }, $oldProducts);
        }


        $strumenti = DB::table('ec_products')->whereIn('id', $strumenti)->pluck('sku')->toArray();
        $customerIDs = DB::table('ec_customers as c')
            ->join('ec_customer_strument as cs', 'c.id', '=', 'cs.customer_id')
            ->when(!empty($filteredCustomerIDsByDate), function ($query) use ($filteredCustomerIDsByDate) {
                return $query->whereIn('c.id', $filteredCustomerIDsByDate);
            })
            ->whereIn('cs.tag_id', $strumenti)
            ->whereIn('c.region_id', $regione)    // Uncomment and add if needed
            ->whereIn('c.agent_id', $agents)      // Uncomment and add if needed
            ->distinct('c.id')
            ->pluck('c.id')
            ->toArray();


        $intersection = array_reduce($incustomers, function ($carry, $item) {
            if ($carry === null) {
                return $item;
            }
            return array_intersect($carry, $item);
        }, null);


        $finalIntersection = array_values(array_intersect($intersection, $customerIDs));


        $finalDifference = array_values(array_diff($intersection, $finalIntersection));


        $data = [
            "customersToCheck" => $finalIntersection,
            "customersToUncheck" => $finalDifference,
            "count" => count($finalIntersection)
        ];


        return $data;


    }


    public function checkIfBetter(Request $request)
    {
        $consumabili = $request->input('consumabili');
        $offer_type = $request->input('offer_type');
        $customers = $request->input('customers');
        $data = [];

        foreach ($consumabili as $consumabilo) {
            $productId = $consumabilo['id'];
            $price = $consumabilo['price'];

            $baseQuery = OffersDetail::where('product_id', $productId)
                ->where('status', 'active');

            switch ($offer_type) {
                case '1':
                case '2':
                case '3':
                    $offerCustomers = $baseQuery->where('product_price', '<=', $price)->pluck('customer_id')->toArray();
                    $diffCustomers = array_diff($customers, $offerCustomers);
                    $data[] = [
                        'product' => Product::find($productId),
                        'customers' => $this->getCustomersFromIds($diffCustomers),
                        'offer_price' => $price,
                        'quantita' => null,
                        'gift_product' => null,
                        'flag_three' => null,
                    ];
                    break;

                case '4':
                    $flagThreeCustomers = $baseQuery->where('flag_three', 1)->pluck('customer_id')->toArray();
                    $diffCustomers = array_diff($customers, $flagThreeCustomers);
                    $data[] = [
                        'product' => Product::find($productId),
                        'customers' => $this->getCustomersFromIds($diffCustomers),
                        'offer_price' => null,
                        'quantita' => null,
                        'gift_product' => null,
                        'flag_three' => 1,
                    ];
                    break;

                case '5':
                    $gift_product_id = $consumabilo['collegati'];
                    $giftProductCustomers = $baseQuery->where('gift_product_id', $gift_product_id)->pluck('customer_id')->toArray();
                    $diffCustomers = array_diff($customers, $giftProductCustomers);
                    $data[] = [
                        'product' => Product::find($productId),
                        'customers' => $this->getCustomersFromIds($diffCustomers),
                        'offer_price' => null,
                        'quantita' => null,
                        'gift_product' => Product::find($gift_product_id),
                        'flag_three' => null,
                    ];
                    break;

                case '6':
                    $quantita = $consumabilo['quantita'];
                    $specialOffers = $baseQuery->where('quantity', '<', $quantita)->where('product_price', '<', $price)->pluck('customer_id')->toArray();
                    $diffCustomers = array_diff($customers, $specialOffers);
                    $data[] = [
                        'product' => Product::find($productId),
                        'customers' => $this->getCustomersFromIds($diffCustomers),
                        'offer_price' => $price,
                        'quantita' => $quantita,
                        'gift_product' => null,
                        'flag_three' => null,
                    ];
                    break;
            }
        }

        return $data;
    }

    private function getCustomersFromIds(array $customerIds): array
    {
        $customersList = [];
        foreach ($customerIds as $customerId) {
            $customersList[] = Customer::find($customerId);
        }
        return $customersList;
    }

    public function saveOffer(Request $request)
    {


        $offer_name = $request->offer_name;
        $offer_starting_date = $request->start_date;
        $offer_expiring_date = $request->expiring_date;
        $offer_type = $request->offer_type;
        $active = 1;

        $offer = new Offers();
        $offer->offer_name = $offer_name;

        $offer->offer_starting_date = $offer_starting_date;
        $offer->offer_expiring_date = $offer_expiring_date;
        $offer->offer_type = $offer_type;
        $offer->active = $active;

        $offer->save();

        $expirationDate = Carbon::parse($offer->offer_expiring_date);
        $offerJob = OfferDeactivationJob::dispatch($offer->id)->delay($expirationDate);
        $offer_details = $request->offer_details;
        foreach ($offer_details as $offer_detail) {
            $productId = $offer_detail['product']['id'];
            $customers = $offer_detail['customers'];

            foreach ($customers as $customer) {

                $offerDetail = new OffersDetail();

                $offerDetail->offer_id = $offer->id;
                $offerDetail->product_id = $productId;
                $offerDetail->customer_id = $customer['id'];
                $offerDetail->quantity = ($offer_detail['quantita']) ? $offer_detail['quantita'] : null;
                $offerDetail->product_price = ($offer_detail['offer_price']) ? $offer_detail['offer_price'] : null;
                $offerDetail->gift_product_id = ($offer_detail['gift_product']) ? $offer_detail['gift_product']['id'] : null;
                $offerDetail->flag_three = ($offer_detail['flag_three']) ? $offer_detail['flag_three'] : null;

                $offerDetail->save();
            }
        }

        return Redirect::to('https://dev.marigo.collaudo.biz/admin/discounts');


    }

    // ruote /admin/ecommerce/offerte/update-offer
    //ruote name (admin.ecommerce.offerte.update-offer)

    public function updateOffer(Request $request)
    {

        $id = $request->input('offerId');
        $offer = Offers::find($id);
        $status = $offer->active;

        if ($status == 1) {
            OfferDeactivationJob::dispatch($offer->id)->delete();
            $offer->active = 0;
            $offer->save();
            OffersDetail::where('offer_id', $offer->id)->update(['status' => 'deactive']);
        } else {
            $expirationDate = Carbon::parse($offer->offer_expiring_date);
            OfferDeactivationJob::dispatch($offer->id)->delay($expirationDate);
            $offer->active = 1;
            $offer->save();
            OffersDetail::where('offer_id', $offer->id)->update(['status' => 'active']);
        }
        return true;
    }

    public function delete(Request $request)
    {
        $id = $request->input('offerId');
        OffersDetail::where('offer_id', $id)->delete();
        Offers::find($id)->delete();
        return true;
    }


    public function editView($id)
    {
        page_title()->setTitle('Modificare offerta');

        $offer = Offers::find($id);
        $offerDetails = OffersDetail::where('offer_id', $id)->get();

        $productIds = $offerDetails->pluck('product_id')->unique();
        $products = Product::whereIn('id', $productIds)->get();


        return view('plugins/ecommerce::offerte.edit', compact('offer', 'offerDetails', 'products'));
    }

    public function checkProductHasActiveOffer(Request $request)
    {
        // Ensure 'product_ids' and 'date' are present in the request.
        if (!$request->has(['product_ids', 'date'])) {
            return response(['error' => 'Missing required parameters.'], 400);
        }

        $productIds = $request->input('product_ids');

        // Fetch active or planned offers details for given product IDs.
        $offersDetails = OffersDetail::whereIn('product_id', $productIds)
            ->where(function ($query) {
                $query->where('status', 'active')
                    ->orWhere('status', 'planned');
            })
            ->get();

        // If no offers are found, return false.
        if ($offersDetails->isEmpty()) {
            return false;
        }

        // Extract unique product and offer IDs from the offers details.
        $productIdsIn = $offersDetails->pluck('product_id')->unique();
        $offerIds = $offersDetails->pluck('offer_id')->unique();

        // Get the max offer expiration date from offers.
        $date = Offers::whereIn('id', $offerIds)->max('offer_expiring_date');
        if (!$date) {
            return response(['error' => 'Failed to retrieve the offer expiration date.'], 500);
        }

        // Convert dates to Carbon instances for comparison.
        $maxOfferDate = Carbon::parse($date);
        $inputDate = Carbon::parse($request->input('date'));

        // If the input date is after the max offer date, return false.
        if ($inputDate->greaterThan($maxOfferDate)) {
            return false;
        }

        // Fetch product names based on the product IDs in the offers.
        $products = Product::whereIn('id', $productIdsIn)->pluck('name');

        return [
            'product' => $products,
            'date' => $maxOfferDate->toDateString(),
            'message' => "Questi prodotti sono in un'offerta attiva, prova a reimpostare il prodotto o riprogrammare dopo " . $maxOfferDate->toDateString()
        ];
    }

    public function deactiveProductInoffer(Request $request)
    {
        $offer_id = $request->input('offer_id');
        $product_id = $request->input('product_id');
        $status = $request->input('status_to');
        OffersDetail::where('offer_id', $offer_id)
            ->where('product_id', $product_id)
            ->update(['status' => $status]);
    }

    public function deactiveCustomerInoffer(Request $request)
    {
        $offer_id = $request->input('offer_id');
        $product_id = $request->input('product_id');
        $customer_id = $request->input('customer_id');
        $status = $request->input('status_to');
        return OffersDetail::where('offer_id', $offer_id)
            ->where('product_id', $product_id)
            ->where('customer_id', $customer_id)
            ->update(['status' => $status]);
    }

    public function exportOfferDetails(Request $request)
    {
        $id = $request->input('offer_id');
        $offer = Offers::find($id);


        // Prepare the CSV file content
        $csvData = "offer_name\n";
        $csvData .= "{$offer->offer_name}\n";
        $csvData .= "--------------\n";

        $offerDetails = OffersDetail::where('offer_id', $id)->get();
        $productIds = $offerDetails->pluck('product_id')->unique();
        $products = Product::whereIn('id', $productIds)->get();
        foreach ($products as $product) {
            // Check if the current offer name is different from the previous one

            $offerDetail = OffersDetail::where('offer_id', $id)->where('product_id', $product->id)->first();
            $csvData .= "SKU,PRODOTTO,PREZZO,PREZZO DI OFFERTA\n";
            $csvData .= "{$product->sku},{$product->name},{$product->price},{$offerDetail->product_price}\n";
            $filteredRecords = $offerDetails->where('product_id', $product->id);
            $customerIds = $filteredRecords->pluck('customer_id')->unique();
            $customers = Customer::whereIn('id', $customerIds)->get();
            $csvData .= "--------------\n";
            foreach ($customers as $customer) {
                $csvData .= "{$customer->codice},{$customer->name}\n";
            }

        }

        // Generate and serve the CSV file as a downloadable response
        $response = Response::stream(function () use ($csvData) {
            echo $csvData;
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename='{$offer->offer_name}.xlsx'",
        ]);

        return $response;


    }


    public function getOfferbyCustomerId(Request $request)
    {
        $userId = $request->input('user_id');

        $offerDetails = OffersDetail::where('customer_id', $userId)->get();
        $offerIds = OffersDetail::where('customer_id', $userId)
            ->where('status', 'active')
            ->pluck('offer_id')
            ->unique()
            ->toArray();

        // Retrieve the offers from the Offer model
        $offers = Offers::whereIn('id', $offerIds)->get();


        // Prepare the CSV file content
        foreach ($offers as $offer) {
            $csvData = "offer_name\n";
            $csvData .= "{$offer->offer_name}\n";
            $csvData .= "--------------\n";

            $productIds = $offerDetails->pluck('product_id')->unique();
            $products = Product::whereIn('id', $productIds)->get();
            foreach ($products as $product) {
                // Check if the current offer name is different from the previous one

                $offerDetail = OffersDetail::where('offer_id', $offer->id)->first();
                $csvData .= "SKU,PRODOTTO,PREZZO,PREZZO DI OFFERTA\n";
                $csvData .= "{$product->sku},{$product->name},{$product->price},{$offerDetail->product_price}\n";
                $filteredRecords = $offerDetails->where('product_id', $product->id);
                $customerIds = $filteredRecords->pluck('customer_id')->unique();
                $customers = Customer::whereIn('id', $customerIds)->get();
                $csvData .= "--------------\n";
                foreach ($customers as $customer) {
                    $csvData .= "{$customer->codice},{$customer->name}\n\n\n\n\n";
                }

            }
        }


        // Generate and serve the CSV file as a downloadable response
        if (!isset($csvData)) {
            return response()->json(['message' => 'Offer not found for the given user ID'], 404);
        }
        $response = Response::stream(function () use ($csvData) {
            echo $csvData;
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename='{$offer->offer_name}.xlsx'",
        ]);

        return $response;
    }


    public function getStrumentOfUser(Request $request)
    {
        $userId = $request->input('user_id');

        if (in_array($userId, [13, 11])) {
            $userId = 2621;
        }

        $str_ids = DB::connection('mysql')
            ->select("SELECT * FROM `ec_customer_strument` WHERE customer_id=?", [$userId]);
        $str_ids = array_column($str_ids, 'tag_id');

        if (!$str_ids) {
            return response()->json(['message' => 'No products found for the given user ID'], 404);
        }

        $products = Product::whereIn('sku', $str_ids)->get();

        $csvData = '';

        foreach ($products as $product) {
            $csvData .= "{$product->sku},{$product->name}\n";
        }

        // Generate and serve the CSV file as a downloadable response
        $response = Response::stream(function () use ($csvData) {
            echo $csvData;
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename='{$userId}.csv'",
        ]);

        return $response;


    }


    public function getListino(Request $request)
    {
        $userId = $request->input('user_id');

        if (in_array($userId, [13, 11])) {
            $userId = 2621;
        }

        $list_ids = DB::connection('mysql')
            ->select("SELECT * FROM `ec_pricelist` WHERE customer_id=?", [$userId]);
        $list_ids = array_column($list_ids, 'product_id');

        if (!$list_ids) {
            return response()->json(['message' => 'No products found for the given user ID'], 404);
        }

        $products = Product::whereIn('id', $list_ids)->get();

        $csvData = '';

        foreach ($products as $product) {
            $csvData .= "{$product->sku},{$product->name}\n";
        }

        // Generate and serve the CSV file as a downloadable response
        $response = Response::stream(function () use ($csvData) {
            echo $csvData;
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename='{$userId}.csv'",
        ]);

        return $response;


    }
}
