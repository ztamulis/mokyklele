<?php

use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\QuestionFormController;
use App\Http\Controllers\RegisterFreeController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\InfoChangeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\CronjobController;
use \App\Http\Controllers\NavbarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post(
    '/stripe/webhook',
    [WebhookController::class, 'handleWebhook']
)->name('cashier.webhook');


Route::get('/', function () {
    return view('landing.main');
})->name('index');
Route::get('/apie-pamokas', function () {
    return view('landing.apie_pamokas');
});
Route::get('/patarimai-tevams', function () {
    return view('landing.patarimai_tėvams');
});
Route::get('/kaina', function () {
    return view('landing.kaina');
});

Route::get('/kaina', function () {
    return view('landing.kaina');
});
Route::get('/susitikimai', function () {
    return view('landing.susitikimai');
});
Route::get('/nemokama-pamoka', function () {
    return view('landing.nemokama_pamoka');
});
Route::get('/komanda', function () {
    return view('landing.komanda');
});
Route::get('/kontaktai', function () {
    return view('landing.kontaktai');
});
Route::get('/privatumo-politika', function () {
    return view('landing.privatumo_politika');
});
Route::get('/zoom-naudojimas', function () {
    return view('landing.zoom_naudojimas');
});

Route::get('/blank', function () {
    return view('landing.blank');
});
Route::get('/courses', function () {
    return view('landing_other.courses');
});
Route::get('/free-l-form', function () {
    return view('landing_other.free-l-form');
});
Route::get('/courses_free', function () {
    return view('landing_other.courses_free');
});

Route::get('/question_form', function () {
    return view('landing_other.question_form');
});

Route::post('/', [UserController::class, 'setRegion']);


Route::get("/cronjob/main", [CronjobController::class, 'main']);
//Route::get("/cronjob/voucher", [GroupController::class, 'voucher']);
//Route::get("/cronjob/checkPaymentsFromStripe", [CronjobController::class, 'checkPaymentsFromStripe']);
Route::get("/payment/sendfailedpayment/{paymentId}", [OrderController::class, 'sendPaymentEmail']);


// coupons
Route::resource('/dashboard/coupons', CouponController::class)->middleware(['auth']);

Route::resource('/questions-form', QuestionFormController::class);

Route::resource('/register-free/admin', RegisterFreeController::class);



Route::post('/set-region', [UserController::class, 'setRegion']);
Route::post('/register-free', [UserController::class, 'registerFree']);
Route::get('/change-timezone', [UserController::class, 'clearRegion']);
//Route::get('/select-group/{id}', [UserController::class, 'selectGroup']);
//Route::post('/select-group/{id}', [UserController::class, 'selectGroupPost']);

// reworked orders
Route::get('/payments/checkout/response', [OrderController::class, 'checkoutResponse'])->middleware(['auth']);
Route::get('/select-group/order/{slug}', [OrderController::class, 'selectGroupOrder'])->middleware(['auth']);
Route::get('/select-group/order/{slug}/confirm', [OrderController::class, 'orderConfirmation'])->middleware(['auth']);
Route::post('/select-group/create-order/{slug}', [OrderController::class, 'createOrderCheckout'])->middleware(['auth']);
Route::get('/select-group/order/free/{slug}', [OrderController::class, 'selectFreeOrder'])->middleware(['auth']);
Route::post('/select-group/order/free/create/{slug}', [OrderController::class, 'createFreeOrder'])->middleware(['auth']);
Route::get('/select-group/order/free/success/{slug}', [OrderController::class, 'showSuccessPage'])->middleware(['auth'])->name('orderFreeSuccess');


Route::get('/dashboard', function () {
    return view('dashboard.index')->with("meetings", \App\Models\Meeting::orderBy('date_at', 'asc')->get());
})->middleware(['auth'])->name('home');
Route::get('/dashboard/navbar', function () {
    return view('dashboard.navbar');
})->middleware(['auth', 'admin'])->name('navbar');
Route::get('/dashboard/wbuilder', function () {
    return view('dashboard.wbuilder');
})->middleware(['auth', 'admin'])->name('wbuilder');
Route::get('/dashboard/editor', function () {
    return view('dashboard.editor');
})->middleware(['auth', 'admin'])->name('editor');
Route::get('/dashboard/tableData', function () {
    return view('dashboard.tableData')->with("users", \App\Models\User::all());
})->middleware(['auth', 'admin'])->name('tableData');
Route::get('/dashboard/free-registrations', function () {
    return view('dashboard.freeRegistrations')->with("freeRegistrations", \App\Models\FreeRegistration::all());
})->middleware(['auth', 'admin'])->name('freeRegistrations');

Route::get('/dashboard/error', function () {
    return view('dashboard.error')->with("error", "Generic error");
})->middleware(['auth'])->name('dashboard.error');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/profile', [UserController::class, 'profile']);
    Route::get('/dashboard/profile/zoom', [UserController::class, 'zoom']);
    Route::post('/dashboard/profile/update-card', [UserController::class, 'updateCard']);
    Route::get('/dashboard/users/export', [UserController::class, 'export']);
    Route::get('/dashboard/billing-portal', function (Request $request) {
        Auth::user()->createOrGetStripeCustomer();
        return Auth::user()->redirectToBillingPortal();
    });
    Route::get('/dashboard/attendance', [EventController::class, 'calendar']);
    Route::get('/dashboard/teacher-statistics', [EventController::class, 'teacherCalendar']);
    Route::get('/dashboard/events/{id}/attendances', [EventController::class, 'attendances']);
    Route::post('/dashboard/events/{id}/attendances', [EventController::class, 'attendancesPost']);
    Route::get('/dashboard/events/{id}/clone', [EventController::class, 'clone']);
    Route::get('/dashboard/events/deleteEvents', [EventController::class, 'deleteEvent']);
    Route::post('/dashboard/groups/upload', [GroupController::class, 'uploadFile']);
    Route::post('/dashboard/groups/homework/{id}/edit', [GroupController::class, 'editGroupHomework']);
    Route::post('/dashboard/groups/upload/{id}/delete', [GroupController::class, 'deleteFile']);
    Route::post('/dashboard/groups/message', [GroupController::class, 'message']);
    Route::post('/dashboard/groups/message/{id}/delete', [GroupController::class, 'deleteMessage']);
    Route::post('/dashboard/groups/message/{id}/edit', [GroupController::class, 'editMessage']);
    Route::get('/dashboard/messages/sent', [MessageController::class, 'sentMessages']);
    Route::resource('/dashboard/users', UserController::class);
    Route::resource('/dashboard/groups', GroupController::class);
    Route::resource('/dashboard/students', StudentController::class);
    Route::resource('/dashboard/events', EventController::class);
    Route::resource('/dashboard/meetings', MeetingController::class);
    Route::resource('/dashboard/messages', MessageController::class);
    Route::resource('/dashboard/payments', PaymentController::class);
    Route::resource('/dashboard/rewards', RewardController::class);
    Route::post('/dashboard/profile/info-change', [InfoChangeController::class, 'infoChange']);
    Route::post('/dashboard/profile/password-change', [InfoChangeController::class, 'passwordChange']);
    Route::post('/dashboard/profile/photo-change', [InfoChangeController::class, 'photoChange']);
    Route::post('/dashboard/profile/profile-photo-change', [InfoChangeController::class, 'profilePhotoChange']);
    Route::post('/dashboard/announcements/message', [MessageController::class, 'sendMessage']);
    Route::post('/dashboard/announcements/news', [MessageController::class, 'sendNew']);
    Route::options('/dashboard/groups/createMessage', [GroupController::class, 'createMessage']);
    Route::post('/dashboard/generate-zoom-signature', [GroupController::class, 'generateZoomSignature']);
    Route::get('/dashboard/create-zoom-meeting/{id}', [EventController::class, 'createZoomMetting']);
    Route::get('/dashboard/events/{event}/zoom', [EventController::class, 'zoom']);
    Route::get('/dashboard/zoom-leave', [EventController::class, 'zoomLeave']);
    Route::get('/dashboard/user-rewards', [RewardController::class, 'userRewards']);
    Route::get('/dashboard/user-rewards/{user}', [RewardController::class, 'adminUserRewards']);
    Route::post('/dashboard/user-rewards/{user}', [RewardController::class, 'adminUserRewardsPost']);
    Route::post('/dashboard/wbuilder/change-names', [InfoChangeController::class, 'pagesNameChange']);
    Route::post('/dashboard/wbuilder/page-delete', [InfoChangeController::class, 'pageDelete']);
    Route::post('/dashboard/wbuilder/file-upload', [InfoChangeController::class, 'fileUpload']);
    Route::post('/dashboard/save-navbar', [NavbarController::class, 'save']);
});


require __DIR__.'/auth.php';

Route::get('{page}', [UserController::class, "customRoute"]);
