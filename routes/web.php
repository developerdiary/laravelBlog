<?php
Route::get('/', function() {
    return redirect(route('admin.dashboard'));
});

Route::get('home', function() {
    return redirect(route('admin.dashboard'));
});




Route::name('admin.')->prefix('admin')->middleware('auth')->group(function() {

    Route::get('dashboard', 'DashboardController')->name('dashboard');
    Route::resource('post', 'PostController');
    Route::resource('category', 'CategoryController');    
    
    Route::get('tag/all', array('as' => 'admin.tag.all', 'uses' => 'TagController@getAllTags'));
    Route::resource('tag', 'TagController');  

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
