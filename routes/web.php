<?php

use App\Http\Controllers\CustomImportController;
use App\Http\Controllers\Email\NormalEmailController;
use App\Http\Controllers\Email\PecEmailController;
use Botble\Ecommerce\Jobs\OrderSubmittedJob;
use Botble\Ecommerce\Jobs\SendQuestionnaireToCustomerJob;
use Botble\Ecommerce\Mail\OrderConfirmed;
use Botble\Ecommerce\Mail\SendQuestionnaireToCustomer;
use Botble\Ecommerce\Models\Order;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\suggestionController;
use App\Http\Controllers\consumabiliFilterController;
use App\Http\Controllers\CreaSconto;
use App\Http\Controllers\FuckingRelatedBlog;
use App\Http\Controllers\SPCController;
use App\Http\Controllers\strumentazioniFilterController;
use Botble\Ecommerce\Http\Controllers\OfferTypeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/importtableUser', [CustomImportController::class, 'importtableUser'])->name('usertable.import');


Route::get('/importposts', [CustomImportController::class, 'importPost'])->name('post.import');
Route::get('/importusers', [CustomImportController::class, 'importUser'])->name('user.import');

Route::get('/test', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
});


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function (Router $router) {
    $router->group(['prefix' => 'emails', 'as' => 'emails.'], function (Router $router) {
        $router->group(['prefix' => 'pec', 'as' => 'pec.'], function (Router $router) {
            Route::get('/', [PecEmailController::class, 'index'])->name('index');
            Route::get('/create', [PecEmailController::class, 'create'])->name('create');
            Route::post('/store', [PecEmailController::class, 'store'])->name('store');
        });
        $router->group(['prefix' => 'normal', 'as' => 'normal.'], function (Router $router) {
            Route::get('/', [NormalEmailController::class, 'index'])->name('index');
            Route::get('/create', [NormalEmailController::class, 'create'])->name('create');
            Route::post('/store', [NormalEmailController::class, 'store'])->name('store');
        });
    });
});

Route::get('test', function () {
    $posts = \Botble\Blog\Models\Post::query()->where('id',46)->get();
    try {
        return DB::transaction(function ()use ($posts){
            foreach ($posts as $post) {
                \App\Jobs\PostContentJob::dispatch($post);
            }
        });
    }catch (Throwable $e){
        dd($e);
    }
});

function does_url_exists($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($code == 200) {
        $status = true;
    } else {
        $status = false;
    }
    curl_close($ch);
    return $status;
}

//Email

/*Route::get('/emails',[\App\Http\Controllers\EmailController::class,'index'])->name('email.index');
Route::get('/email/send',[\App\Http\Controllers\EmailController::class,'showFormSend'])->name('email.send');
Route::post('/email/send',[\App\Http\Controllers\EmailController::class,'send']);
Route::get('/check', function () {
    Schema::create('failed_jobs', function (Blueprint $table) {
        $table->increments('id');
        $table->text('connection');
        $table->text('queue');
        $table->longText('payload');
        $table->longText('exception');
        $table->timestamp('failed_at')->useCurrent();
    });
});
Route::get('/emailpendings',[\App\Http\Controllers\EmailController::class,'pending'])->name('email.pending');

//Pec

Route::get('/pecs',[\App\Http\Controllers\PecController::class,'index'])->name('pec.index');
Route::get('/pec/send',[\App\Http\Controllers\PecController::class,'showFormSend'])->name('pec.send');
Route::post('/pec/send',[\App\Http\Controllers\PecController::class,'send']);
Route::get('/check', function () {
    Schema::create('failed_jobs', function (Blueprint $table) {
        $table->increments('id');
        $table->text('connection');
        $table->text('queue');
        $table->longText('payload');
        $table->longText('exception');
        $table->timestamp('failed_at')->useCurrent();
    });
});
Route::get('/emailpendings',[\App\Http\Controllers\PecController::class,'pending'])->name('Pec.pending');*/

