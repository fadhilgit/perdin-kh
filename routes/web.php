<?php

use App\Http\Controllers\DashboardController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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


Auth::routes();
Route::get('/getSubUk/{id}', 'ComponentController@getSubUk');
Route::get('/register','Auth\RegisterController@showRegistrationForm')->name('register');

Route::group(['middleware'=>['prevent-back-history']], function (){
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('loginPage');
});
Route::group(['middleware'=> ['auth']], function(){

    Route::prefix('dashboard')->group(function() {

        Route::get('/','DashboardController@index')->name('dashboard');
        Route::post('/import', 'DashboardController@importPerdin')->name('dashboard-import');
        Route::get('/createPerdin','DashboardController@createPerdin')->name('createPerdin');
        Route::post('/createPerdin/store','DashboardController@storePerdin')->name('storePerdin');

        Route::get('/detail/{id}', 'DashboardController@show');
        Route::post('/detail/sub-discussion/store', 'DashboardController@storeSubSubject')->name('subSubjectStore');
        Route::post('/detail/discussion/store', 'DashboardController@storeSubject')->name('subjectStore');
        Route::put('/detail/update/{id}', 'DashboardController@update');
        Route::put('/detail/updateSubject/{id}', 'DashboardController@updateSubject');

        Route::post('/detail/sendReview/{id}', 'DashboardController@sendReview');
        Route::post('/detail/finishRev/{id}','DashboardController@finishRev');
        // Image
        Route::post('/detail/updateSubject/image/{id}', 'DashboardController@updateImage');
        Route::delete('/detail/delete/image/{id}', 'DashboardController@destroyImage');
        // End

        // Attachment
        Route::post('/detail/updateAttachment/{id}', 'DashboardController@updateAttachment');
        // End

        // Verification
        Route::post('/detail/verification/{id}', 'DashboardController@verificationPerdin');

        // Review
        // Route::get('/detail/review/{id}', 'DashboardController@review');

        // Print perdin
        Route::get('/detail/print/{id}','DashboardController@printPerdin');

        Route::delete('/detail/deleteSubject/{id}', 'DashboardController@destroySubject');
    });

    Route::prefix('inspector')->group(function() {

        Route::get('/','InspectorController@index')->name('inspector');
        Route::get('/get/comment/{id}','InspectorController@comment');
        Route::post('/comment/post', 'InspectorController@postCommentPerdin')->name('postComment');
    });

    Route::prefix('userperdin')->group(function() {
        Route::get('/', 'UserperdinController@index')->name('userPerdin');
    });

});

// Component for get sub unitk kerja


Route::get('/home', 'HomeController@index')->name('home');
