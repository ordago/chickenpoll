<?php
Route::view('/', 'index')->name('index');

Auth::routes();

// {profile} is an username.
// "me" is an exception which returns username of the current authenticated user.
Route::get('profile/{profile}', 'ProfileController@show')->name('profile.show');

Route::group(['middleware' => ['permission:admin-dashboard'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('/', 'HomeController@index')->name('admin-dashboard');

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UserController@index')->name('admin.users.index');
        Route::get('/{id}', 'UserController@edit')->name('admin.users.edit');
        Route::post('/{id}', 'UserController@update')->name('admin.users.update');
    });
    Route::group(['prefix' => 'role'], function () {
        Route::get('/', 'RoleController@index')->name('admin.roles.index');
        Route::get('/{id}', 'RoleController@edit')->name('admin.roles.edit');
        Route::post('/', 'RoleController@store')->name('admin.roles.store');
        Route::patch('/{id}', 'RoleController@update')->name('admin.roles.update');
        Route::delete('/{id}', 'RoleController@destroy')->name('admin.roles.destroy');
    });

    Route::group(['prefix' => 'poll'], function () {
        Route::get('/', 'PollController@index')->name('admin.polls.index');
        Route::get('/{id}', 'PollController@edit')->name('admin.polls.edit');
        Route::patch('/{id}', 'PollController@update')->name('admin.polls.update');
        Route::delete('/{id}', 'PollController@destroy')->name('admin.polls.destroy');
    });

    Route::group(['prefix' => 'report'], function () {
        Route::get('/', 'ReportController@index')->name('admin.reports.index');
        Route::get('/{id}', 'ReportController@show')->name('admin.reports.show');
        Route::delete('/', 'ReportController@destroy')->name('admin.reports.destroy');
    });

    Route::group(['prefix' => 'visitor'], function () {
        Route::get('/', 'VisitorController@index')->name('admin.visitors.index');
    });
});

Route::get('/sitemap.xml', 'SitemapController@index');
Route::get('/sitemaps/{id}.xml', 'SitemapController@show')->name('sitemaps.polls');

Route::get('/report/{id}', 'ReportController@index')->name('report.index');
Route::post('/report/{id}', 'ReportController@store')->name('report.store');

Route::post('/add', 'PollController@store')->name('polls.store');
Route::get('/{id}', 'PollController@show')->name('polls.show');

Route::post('/vote', 'AnswerController@store')->name('answers.store');