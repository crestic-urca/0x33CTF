<?php

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

/*
|--------------------------------------------------------------------------
| Resources Cheatsheet (from laravel/docs)
|--------------------------------------------------------------------------
|
| Route::resource('photos', 'PhotoController');
|
| Verb      | URI                    | Action       | Route Name
| ----------|------------------------|--------------|---------------------
| GET       | /photos                | index        | photos.index
| GET       | /photos/create         | create       | photos.create
| POST      | /photos                | store        | photos.store
| GET       | /photos/{photo}        | show         | photos.show
| GET       | /photos/{photo}/edit   | edit         | photos.edit
| PUT/PATCH | /photos/{photo}        | update       | photos.update
| DELETE    | /photos/{photo}        | destroy      | photos.destroy
|
| viewers: index create show edit
| actions: store update destroy
*/



// middleware alliases are defined in app/Http/Kernel.php

// in the comments :
// `viewer:` the page is only displaying some infos (or a form)
// `action:` the request will modify something, and display the result
// `resource:` mix of viewers and actions



// private zone admin
Route::middleware('admin')->group(function() {

    /* option pour reset le site 
    Route::get('/clear_site', function() {
        $configCache = Artisan::call('migrate:fresh');
        return('/');
    }); */
    Route::get('admin/subject/{sujet}', 'AdminController@showing_one_subject')->name('sujets.showing_one_subject_admin');

    //// admin ////
    Route::post('admin/__ajax_sujets', 'AdminController@__ajax_sujets')->name('team.__ajax_sujets_admin');
    Route::post('admin/__ajax_player_list', 'AdminController@__ajax_player_list')->name('team.__ajax_player_list');
    Route::post('admin/configuration', 'AdminController@configuration')->name('admin.configuration');

    // actions:
    Route::post('admin/hide_multiple', 'AdminController@hide_multiple')->name('admin.hide_multiple');
    Route::post('admin/show_multiple', 'AdminController@show_multiple')->name('admin.show_multiple');
    Route::post('admin/delete_multiple', 'AdminController@delete_multiple')->name('admin.delete_multiple');

    Route::post('admin/hide/{sujet}', 'AdminController@hide')->name('admin.hide');
    Route::post('admin/show/{sujet}', 'AdminController@show')->name('admin.show');
    Route::post('admin/upgrade/{user}',   'AdminController@upgrade')->name('admin.upgrade');
    Route::post('admin/downgrade/{creator}', 'AdminController@downgrade')->name('admin.downgrade');

    // viewers:
    Route::get ('admin/users', 'AdminController@show_creator')->name('admin.show_creator');
    Route::get ('admin/categories', 'AdminController@show_categorie')->name('admin.show_categorie');
    Route::get ('admin/config', 'AdminController@config')->name('admin.config');

    //// Category ////

    Route::resource('category','CategorieController')
        ->only(['store','destroy']);
});

// private zone ctf_player
Route::middleware('ctf_player')->group(function() {

    //// Subject ////
    Route::get('subject/{sujet}', 'UserController@showing_one_subject')->name('sujets.showing_one_subject')->middleware('started');

    //// Category ////
    Route::post('categorie/__ajax_sujets', 'UserController@__ajax_sujets')->name('team.__ajax_sujets')->middleware('started');
        
    /// actions:
    Route::post('player/{sujet}','UserController@validate_ctf')->name('player.validate_ctf')->middleware('started');
    
    
    //// Team ////
    
    /// actions:
    Route::post('team/__ajax_team', 'TeamController@__ajax_team')->name('team.__ajax_team');
    Route::post('team/__ajax_invite_player', 'TeamController@__ajax_invite_player')->name('team.__ajax_invite_player');

    Route::post('team/invite_refuse/{team}', 'TeamController@invite_refuse')->name('team.invite_refuse');
    Route::post('team/invite_accept/{team}', 'TeamController@invite_accept')->name('team.invite_accept');

    Route::post('team/invite/{user}', 'TeamController@team_send')->name('team.see_user_invite_list_post');
    Route::post('team/refuse/{user}', 'TeamController@team_refuse')->name('team.team_refuse');
    Route::post('team/accept/{user}', 'TeamController@team_accept')->name('team.team_accept');

    Route::post('team/join/{team}', 'TeamController@team_demand')->name('team.choose_team_post');
    Route::get ('team/leave', 'TeamController@leave')->name('team.leave');

    /// viewers:
    Route::get ('team/invitations', 'TeamController@see_invitation_list')->name('team.see_invitation_list');
    Route::get ('team/invite', 'TeamController@see_user_invite_list')->name('team.see_user_invite_list');
    Route::get ('team/requests', 'TeamController@request_list')->name('team.request_list');
    Route::get ('team/join', 'TeamController@choose_team')->name('team.choose_team');

    Route::resource('team', 'TeamController')
        ->except(['show']); // index create edit | store update destroy

    Route::resource('challenges','UserController')
        ->only(['index'])->middleware('started');
});

// private zone ctf_creator
Route::middleware('ctf_creator')->group(function() {
    //// Creator ////
    Route::resource('subjects','SujetController')->parameters(['subjects' => 'sujet',])
        ->except(['show','edit']); // index create edit | store update destroy

    Route::get ('subjects/edit/{sujet}', 'SujetController@edit')->name('subjects.edit');
});

//Public
Route::resource('scoreboard', 'ScoreBoardController')
    ->only(['index']);
Route::get('teams', 'ShowTeamController@index')->name('teams.index');
Route::get('teams/{team}', 'ShowTeamController@showing_one_team')->name('teams.showing_one_team');
Route::get('help', 'HelpController@index')->name('help.index');

// definition of routes related to authentification
Auth::routes(['verify' => true]);
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

// private zone, authentified
Route::middleware('auth')->group(function() {
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
});

// private zone, authentified and email verified
Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('home', 'HomeController@index')->name('home');
});


// public zone
Route::get('/', 'RootController@index')->name('root.index');

Route::get('/nicetry', function () {
    return view('rickrolled');
});
