<?php

// Route::get('/', 'AppController@get');

Route::get('/', function() {
    return redirect(route('admin.dashboard'));
});

Route::get('home', function() {
    return redirect(route('admin.dashboard'));
});

Route::get('blog', [
    'as' => 'blog', 'uses' => 'PostController@index'
]);

Route::get('blog/{slug}', 'PostController@postBySlug');

Route::name('admin.')->prefix('admin')->middleware('auth')->group(function() {

    Route::get('dashboard', 'Admin\DashboardController')->name('dashboard');
    Route::resource('post', 'Admin\PostController');
    Route::resource('category', 'Admin\CategoryController');    
    
    Route::get('tag/all', array('as' => 'tag.all', 'uses' => 'Admin\TagController@getAllTags'));
    Route::resource('tag', 'Admin\TagController');    

    Route::get('users/roles', 'UserController@roles')->name('users.roles');
    Route::resource('users', 'UserController', [
        'names' => [
            'index' => 'users'
        ]
    ]);
});

Route::middleware('auth')->get('logout', function() {
    Auth::logout();
    return redirect(route('login'))->withInfo('You have successfully logged out!');
})->name('logout');

Auth::routes(['verify' => true]);

Route::name('js.')->group(function() {
    Route::get('dynamic.js', 'JsController@dynamic')->name('dynamic');
});

// Get authenticated user
Route::get('users/auth', function() {
    return response()->json(['user' => Auth::check() ? Auth::user() : false]);
});
