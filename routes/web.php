<?php
use App\Http\Controllers\CustomImportController;
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
Route::get('/importDbfrom', function () {
    return view('import');
});


Route::get('/importposts', [CustomImportController::class, 'importPost'])->name('post.import');
Route::get('/importusers', [CustomImportController::class, 'importUser'])->name('user.import');
Route::get('/test',function (){
    \Illuminate\Support\Facades\Artisan::call('storage:link');
});

//Email

Route::get('/emails',[\App\Http\Controllers\EmailController::class,'index'])->name('email.index')->middleware(['auth', 'XSS']);
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
