<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\GroupQuestFormController;
use App\Http\Controllers\Pages\ContactsPageController;
use App\Http\Controllers\Pages\CoursesAdultsPageController;
use App\Http\Controllers\Pages\FreeLessonPageController;
use App\Http\Controllers\Pages\HomePageController;
use App\Http\Controllers\Pages\LithuanianCoursesController;
use App\Http\Controllers\Pages\MeetingsPageController;
use App\Http\Controllers\Pages\IntroductionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Pages\NotificationsController;
use App\Http\Controllers\Pages\PricePageController;
use App\Http\Controllers\Pages\SuggestionController;
use App\Http\Controllers\Pages\SuggestionsPageController;
use App\Http\Controllers\QuestionFormController;
use App\Http\Controllers\RegisterFreeController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\WebhookController;
use App\Models\SettingsModels\ContactsPageContent;
use App\Models\SettingsModels\CoursesAdultsPageContent;
use App\Models\SettingsModels\FreeLessonPageContent;
use App\Models\SettingsModels\HomePageContent;
use App\Models\SettingsModels\LithuanianLanguagePageContent;
use App\Models\SettingsModels\MeetingPageContent;
use App\Models\SettingsModels\PricePageContent;
use App\Models\SettingsModels\SuggestionPageContent;
use App\Models\TeamMember;
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
    return view('landing.main_new')->with('siteContent',  app(HomePageContent::class)->getPageContent());
})->name('index');
Route::get('/apie-pamokas', function () {
    return view('landing.apie_pamokas');
});
//Route::get('/test-patarimai-tevams', function () {
//    return view('landing.patarimai_tėvams');
//});
Route::get('/kaina', function () {
    return view('landing_new.kaina_naujas')->with('siteContent',  app(PricePageContent::class)->getPageContent());

});

//Route::get('/kaina', function () {
//    return view('landing.kaina');
//});
Route::get('/susitikimai', function () {
    return view('landing.susitikimai');
});
Route::get('/suaugusiuju-kursai', function () {
    return view('landing_new.suagusiuju_kursai_naujas')->with('siteContent',  app(CoursesAdultsPageContent::class)->getPageContent());

});



Route::get('/susitikimai', function () {
    return view('landing_new.susitikimai_naujas')
        ->with("meetings", \App\Models\Introduction::orderBy('date_at', 'desc')->get())
        ->with("before", \App\Models\Introduction::where('date_at', '<', \Carbon\Carbon::now('utc'))->orderBy('date_at', 'desc')->get())
        ->with("coming", \App\Models\Introduction::where('date_at', '>', \Carbon\Carbon::now('utc'))->orderBy('date_at', 'asc')->get())
        ->with('siteContent',  app(MeetingPageContent::class)->getPageContent());
});

Route::get('/patarimai-tevams', function () {

    return view('landing_new.patarimai_naujas')
        ->with("suggestions", \App\Models\Suggestion::orderBy('created_at', 'desc')->get())
        ->with('siteContent',  app(SuggestionPageContent::class)->getPageContent());
});
//Route::get('/nemokama-pamoka', function () {
//    return view('landing.nemokama_pamoka');
//});

Route::get('/nemokama-pamoka', function () {
    return view('landing_new.nemokama_pamoka_naujas')->with('siteContent',  app(FreeLessonPageContent::class)->getPageContent());
});
//
//Route::get('/komanda', function () {
//    return view('landing.komanda');
//});
Route::get('/komanda', function () {
    return view('landing_new.komanda_naujas')->with('teamMembers', TeamMember::ordered()->get());
});
Route::get('/kontaktai', function () {
    return view('landing_new.kontaktai_naujas')->with('siteContent',  app(ContactsPageContent::class)->getPageContent());
});

Route::get('/privatumo-politika', function () {
    return view('landing.privatumo_politika');
});
Route::get('/zoom-naudojimas', function () {
    return view('landing.zoom_naudojimas');
});

Route::get('lietuviu-kalbos-pamokos', function () {
    return view('landing_new.lietuviu_kalbos_pamokos_naujas')
        ->with('siteContent',  app(LithuanianLanguagePageContent::class)->getPageContent());
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

Route::get('/courses_adults_free', function () {
    return view('landing_other.courses_adults_free');
});

Route::get('/courses_adults', function () {
    return view('landing_other.courses_adults');
});

Route::post('/', [UserController::class, 'setRegion']);


//edit page contents


Route::get("/cronjob/main", [CronjobController::class, 'main']);
//Route::get("/cronjob/voucher", [GroupController::class, 'voucher']);
//Route::get("/cronjob/checkPaymentsFromStripe", [CronjobController::class, 'checkPaymentsFromStripe']);
Route::get("/payment/sendfailedpayment/{paymentId}", [OrderController::class, 'sendPaymentEmail']);


// coupons

Route::resource('/questions-form', QuestionFormController::class);

Route::resource('/register-free/admin', RegisterFreeController::class)->middleware(['auth']);



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



Route::post('/lietuviu-kalbos-pamokos/anketa', [GroupQuestFormController::class, 'submitResults'])->name('lithuanian-language-form-submit');
Route::post('/lietuviu-kalbos-pamokos/perkrauti', [GroupQuestFormController::class, 'reset'])->name('lithuanian-language-form-reset');


    Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], static function () {
        Route::get('', function () {
            return view('dashboard.index')->with("meetings", \App\Models\Meeting::orderBy('date_at', 'asc')->where("date_at", ">" ,\Carbon\Carbon::now('utc')->subMinutes(120))->orderBy("date_at","ASC")->get());
        })->name('home');
        Route::get('', function () {
            return view('dashboard.index')->with("meetings", \App\Models\Meeting::orderBy('date_at', 'asc')->where("date_at", ">" ,\Carbon\Carbon::now('utc')->subMinutes(120))->orderBy("date_at","ASC")->get());
        })->name('home');
        Route::get('/navbar', function () {
            return view('dashboard.navbar');
        })->name('navbar');
        Route::get('/wbuilder', function () {
            return view('dashboard.wbuilder');
        })->name('wbuilder');
        Route::get('/editor', function () {
            return view('dashboard.editor');
        })->name('editor');
        Route::get('/tableData', function () {
            return view('dashboard.tableData')->with("users", \App\Models\User::all());
        })->name('tableData');
        Route::get('/free-registrations', function () {
            return view('dashboard.freeRegistrations')->with("freeRegistrations", \App\Models\FreeRegistration::all());
        })->name('freeRegistrations');

        Route::get('/error', function () {
            return view('dashboard.error')->with("error", "Generic error");
        })->name('dashboard.error');
        Route::get('/profile', [UserController::class, 'profile']);
        Route::get('/profile/zoom', [UserController::class, 'zoom']);
        Route::post('/profile/update-card', [UserController::class, 'updateCard']);
        Route::get('/users/export', [UserController::class, 'export']);
        Route::get('/billing-portal', function (Request $request) {
            Auth::user()->createOrGetStripeCustomer();
            return Auth::user()->redirectToBillingPortal();
        });
        Route::get('/attendance', [EventController::class, 'calendar']);
        Route::get('/teacher-statistics', [EventController::class, 'teacherCalendar']);
        Route::get('/events/{id}/attendances', [EventController::class, 'attendances']);
        Route::post('/events/{id}/attendances', [EventController::class, 'attendancesPost']);
        Route::get('/events/{id}/clone', [EventController::class, 'clone']);
        Route::get('/events/deleteEvents', [EventController::class, 'deleteEvent']);
        Route::post('/groups/upload', [GroupController::class, 'uploadFile'])->name('homework-store')->middleware('auth');
        Route::get('/groups/test/{group}', [GroupController::class, 'showTest'])->middleware('auth');
        Route::post('/groups/homework/{id}/edit', [GroupController::class, 'editGroupHomework'])->name('homework-edit');
        Route::post('/groups/upload/{id}/delete', [GroupController::class, 'deleteFile'])->name('delete-homework-file');
        Route::post('/groups/message', [GroupController::class, 'message']);
        Route::post('/groups/message/{id}/delete', [GroupController::class, 'deleteMessage'])->name('delete-group-message');
        Route::post('/groups/message/{id}/edit', [GroupController::class, 'editMessage'])->name('edit-group-message');
        Route::get('/messages/sent', [MessageController::class, 'sentMessages']);
        Route::resource('/users', UserController::class);
        Route::resource('/groups', GroupController::class);
        Route::resource('/students', StudentController::class);
        Route::resource('/events', EventController::class);
        Route::resource('/meetings', MeetingController::class);
        Route::resource('/introductions', IntroductionController::class);
        Route::resource('/messages', MessageController::class);
        Route::resource('/payments', PaymentController::class);
        Route::resource('/rewards', RewardController::class);
        Route::resource('/suggestions', SuggestionController::class);
        Route::post('/profile/info-change', [InfoChangeController::class, 'infoChange']);
        Route::post('/profile/password-change', [InfoChangeController::class, 'passwordChange']);
        Route::post('/profile/photo-change', [InfoChangeController::class, 'photoChange']);
        Route::post('/profile/profile-photo-change', [InfoChangeController::class, 'profilePhotoChange']);
        Route::post('/announcements/message', [MessageController::class, 'sendMessage']);
        Route::post('/announcements/news', [MessageController::class, 'sendNew']);
        Route::options('/groups/createMessage', [GroupController::class, 'createMessage'])->name('create-message-conversations');
        Route::post('/generate-zoom-signature', [GroupController::class, 'generateZoomSignature']);
        Route::get('/create-zoom-meeting/{id}', [EventController::class, 'createZoomMetting']);
        Route::get('/events/{event}/zoom', [EventController::class, 'zoom']);
        Route::get('/zoom-leave', [EventController::class, 'zoomLeave']);
        Route::get('/user-rewards', [RewardController::class, 'userRewards']);
        Route::get('/user-rewards/{user}', [RewardController::class, 'adminUserRewards']);
        Route::post('/user-rewards/{user}', [RewardController::class, 'adminUserRewardsPost']);
        Route::post('/wbuilder/change-names', [InfoChangeController::class, 'pagesNameChange']);
        Route::post('/wbuilder/page-delete', [InfoChangeController::class, 'pageDelete']);
        Route::post('/wbuilder/file-upload', [InfoChangeController::class, 'fileUpload']);
        Route::post('/save-navbar', [NavbarController::class, 'save']);
        Route::resource('/coupons', CouponController::class);

        Route::group(['prefix' => 'reminders', 'as' => 'reminders.'], static function () {
            Route::get('/', [NotificationsController::class, 'index'])->name('index');
            Route::get('/edit', [NotificationsController::class, 'edit'])->name('edit');
            Route::put('/update', [NotificationsController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [NotificationsController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'pages', 'as' => 'pages.'], static function () {
            Route::get('/', function () {
                return view('dashboard.pages');
            })->name('index');
            Route::group(['prefix' => 'introductions-config', 'as' => 'introductions-config.'], static function () {
                Route::get('/', [MeetingsPageController::class, 'edit'])->name('edit');
                Route::put('/update', [MeetingsPageController::class, 'update'])->name('update');
                Route::resource('introductions', IntroductionController::class);

            });

            Route::resource('team-member', TeamMemberController::class);
            Route::post('team/sort',  [TeamMemberController::class, 'sortTeamMember'])->name('team-member.sort');


            Route::group(['prefix' => 'home-page', 'as' => 'home-page.'], static function () {
                Route::get('/', [HomePageController::class, 'edit'])->name('edit');
                Route::put('/update', [HomePageController::class, 'update'])->name('update');
            });
            Route::group(['prefix' => 'courses-adults', 'as' => 'courses-adults.'], static function () {
                Route::get('/', [CoursesAdultsPageController::class, 'edit'])->name('edit');
                Route::put('/update', [CoursesAdultsPageController::class, 'update'])->name('update');
            });
            Route::group(['prefix' => 'free-lessons', 'as' => 'free-lessons.'], static function () {
                Route::get('/', [FreeLessonPageController::class, 'edit'])->name('edit');
                Route::put('/update', [FreeLessonPageController::class, 'update'])->name('update');
            });
            Route::group(['prefix' => 'prices', 'as' => 'prices.'], static function () {
                Route::get('/', [PricePageController::class, 'edit'])->name('edit');
                Route::put('/update', [PricePageController::class, 'update'])->name('update');
            });
            Route::group(['prefix' => 'contacts', 'as' => 'contacts.'], static function () {
                Route::get('/', [ContactsPageController::class, 'edit'])->name('edit');
                Route::put('/update', [ContactsPageController::class, 'update'])->name('update');
            });
            Route::group(['prefix' => 'suggestions', 'as' => 'suggestions-config.'], static function () {
                Route::get('/', [SuggestionsPageController::class, 'edit'])->name('edit');
                Route::put('/update', [SuggestionsPageController::class, 'update'])->name('update');
                Route::resource('list', SuggestionController::class);
            });
            Route::group(['prefix' => 'suggestions', 'as' => 'suggestions-config.'], static function () {
                Route::get('/', [SuggestionsPageController::class, 'edit'])->name('edit');
                Route::put('/update', [SuggestionsPageController::class, 'update'])->name('update');
                Route::resource('list', SuggestionController::class);
            });
            Route::group(['prefix' => 'lithuanian-courses-children', 'as' => 'lithuanian-courses-children.'], static function () {
                Route::get('/', [LithuanianCoursesController::class, 'index'])->name('index');
                Route::get('/edit', [LithuanianCoursesController::class, 'edit'])->name('edit');
                Route::put('/update', [LithuanianCoursesController::class, 'update'])->name('update');
            });
        });
    });

    if (config('comments.route.custom') !== null) {
        Route::group(['prefix' => config('comments.route.custom')], static function () {
            Route::group(['prefix' => config('comments.route.group'), 'as' => 'comments.',], static function () {
                Route::get('/', [CommentsController::class, 'get'])->name('get');
                Route::post('/', [CommentsController::class, 'store'])->name('store');
                Route::delete('/{comment}', [CommentsController::class, 'destroy'])->name('delete');
                Route::put('/{comment}', [CommentsController::class, 'update'])->name('update');
                Route::get('/{comment}', [CommentsController::class, 'show']);
                Route::post('/{comment}', [CommentsController::class, 'reply'])->name('reply');
            });
        });
    }





require __DIR__.'/auth.php';

Route::get('{page}', [UserController::class, "customRoute"]);
