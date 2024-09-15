<?php

use App\Http\Controllers\Controller;
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

Route::group(['middleware' => ['auth']], function () {
    // Home Controller
    Route::get('/', [Controller::class, 'index'])->name('home');

    // ======================= Admin Routes ======================== //
    Route::group(['middleware' => 'Role:Admin' , 'controller' => 'Admin\AdminViewsController'], function () {
        // Dashboard
        Route::get('/Dashboard', 'dashboard')->name('Dashboard');
        // Users
        Route::resource('Users', 'Admin\CreateUserController');
        // Inquiries
        Route::get('/Inquiries', 'inquiries')->name('Inquiries');
    });

    // ======================= Employees Routes ======================= //
    Route::group(['middleware' => 'Role:Employee', 'controller' => 'Admin\AdminViewsController'], function () {
        // Requests
        Route::get('/Requests', 'requests')->name('Requests');
        Route::get('View-Request', 'viewRequest')->name('View-Request');
        // OfferPrices
        Route::get('/Offer-Prices/{rid}', 'offerPrices')->name('Offer-Prices');
        Route::get('/Create-Offer', 'createOfferPrice')->name('Create-Offer');
        Route::get('/Edit-OfferPrice', 'editOfferPrice')->name('Edit-OfferPrice');
        // Chats
        Route::get('/Chats', 'chats')->name('Chats-Admin');
        Route::get('/Contact', 'contact')->name('Contact');
        // Achivements
        Route::get('/Achievements', 'achievements')->name('Achievements');
        Route::get('/View-Achievement', 'viewAchievement')->name('View-Achievement');
        // Remarks
        Route::get('/Remarks', 'remarks')->name('Remarks');
    });

    // ======================= Customers Routes ======================= //
    Route::group(['prefix' => 'Customer', 'middleware' => 'Role:Customer', 'controller' => 'Customer\CustomerViewsController'], function () {
        // Home
        Route::get('/Home', 'home')->name('Home');
        // Customer Request
        Route::get('/IntializeRequest', 'intializeRequest')->name('Intialize-Request');
        Route::get('/CreateRequest', 'createRequest')->name('Create-Request');
        Route::get('/EditRequest', 'editRequest')->name('Edit-Request');
        Route::get('/ViewRequest', 'viewRequest')->name('Customer-View-Request');
        // Customer Offer-Prices
        Route::get('/OfferPrice', 'offerPrices')->name('Offer-Price');
        // Customer Chats
        Route::get('/Chat', 'chats')->name('Chats-Customer');
        // Governmental Employee Resource
        Route::resource('/Employees', 'Customer\GovernmentalEmployeeController');
    });

    // ======================= PDF Routes ======================= //
    Route::controller('Common\PDFController')->group(function () {
        // PDF & Offer Price
        Route::get('/View-OfferPrice', 'viewOfferPrice')->name('View-OfferPrice');

        // Print
        Route::prefix('/Print')->group(function () {
            Route::get('/OfferPrice', 'pdf')->name('Print-PDF');
            Route::get('/Achievement', 'achivementsPdf')->name('Achivement-PDF');
        });
    });

    // ======================= Profile Routes ======================= //
    Route::prefix('Profile')->controller('Common\ProfileController')->group(function () {
        // Profile
        Route::get('/edit', 'edit')->name('profile.edit');
        Route::patch('/update', 'update')->name('profile.update');
        Route::delete('/destroy', 'destroy')->name('profile.destroy');
    });

    // ======================= Language Route ======================= //
    Route::get('languageConverter/{locale}', function ($locale) {
        if (in_array($locale, ['ar', 'en'])) {
            session()->put('locale', $locale);
        }
        return redirect()->back();
    })->name('languageConverter');
});

require __DIR__ . '/auth.php';
