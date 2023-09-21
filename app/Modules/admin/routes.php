<?php

Route::group(['module' => 'admin', 'prefix' => 'admin', 'middleware' => ['web','admin.auth'],'namespace' => 'App\Modules\Admin\Controllers'], function() {
//Route::group(], function () {
  // Admin User routes

  Route::get('users', array('as' => 'users','uses' => 'UsersController@index'));
  Route::get('users/listing', array('as' => 'listing_user','uses' => 'UsersController@listing'));
  Route::get('users/edit/{id}',array('as' => 'edit_user','uses' => 'UsersController@edit'));
  Route::post('users/update',array('as' => 'update_user','uses' => 'UsersController@update'));
  Route::get('users/add',array('as' => 'add_user','uses' => 'UsersController@add'));
  Route::post('users/store',array('as' => 'store_user','uses' => 'UsersController@store'));
  Route::get('users/change_password',array('as' => 'change_user_password','uses' => 'UsersController@changePassword'));
  Route::post('users/password_store',array('as' => 'store_user_password','uses' => 'UsersController@storePassword'));
  Route::get('users/{id}',array('as' => 'delete_user','uses' => 'UsersController@destroy'));
	
  
  //Site User routes
  Route::get('site_users', array('as' => 'site_users','uses' => 'ClientController@index'));
  Route::get('site_users/listing', array('as' => 'listing_site_user','uses' => 'ClientController@listing'));
  Route::get('site_users/change_password/{id}',array('as' => 'change_site_user_password','uses' => 'ClientController@changePassword'));
  Route::post('site_users/password_store',array('as' => 'store_site_user_password','uses' => 'ClientController@storePassword'));
  Route::get('block_user/{id}',array('as' => 'block_user','uses' => 'ClientController@block'));
  Route::get('site_users/job_applied/{id}',array('as' => 'show_job_applied','uses' => 'ClientController@showAppliedJob'));
  Route::get('site_users/job_posted/{id}',array('as' => 'show_job_posted','uses' => 'ClientController@showPostedJob'));
  Route::get('site_users/{id}',array('as' => 'delete_site_user','uses' => 'ClientController@destroy'));
  
  
  // Role routes
  Route::get('roles', array('as' => 'roles','uses' => 'RolesController@index'));
  Route::get('roles/listing', array('as' => 'listing_role','uses' => 'RolesController@listing'));
  Route::get('roles/edit/{id}',array('as' => 'edit_role','uses' => 'RolesController@edit'));
  Route::post('roles/update',array('as' => 'update_role','uses' => 'RolesController@update'));
  Route::get('roles/add',array('as' => 'add_role','uses' => 'RolesController@add'));
  Route::post('roles/store',array('as' => 'store_role','uses' => 'RolesController@store'));
  Route::get('roles/{id}',array('as' => 'delete_role','uses' => 'RolesController@destroy'));
  

  // Categorie routes
  Route::get('categories', array('as' => 'categories','uses' => 'CategoriesController@index'));
  Route::get('categories/listing', array('as' => 'listing_categorie','uses' => 'CategoriesController@listing'));
  Route::get('categories/edit/{id}',array('as' => 'edit_categorie','uses' => 'CategoriesController@edit'));
  Route::post('categories/update',array('as' => 'update_categorie','uses' => 'CategoriesController@update'));
  Route::get('categories/add',array('as' => 'add_categorie','uses' => 'CategoriesController@add'));
  Route::post('categories/store',array('as' => 'store_categorie','uses' => 'CategoriesController@store'));
  Route::get('categories/{id}',array('as' => 'delete_categorie','uses' => 'CategoriesController@destroy'));
  

  // Country routes
  Route::get('countries', array('as' => 'countries','uses' => 'CountriesController@index'));
  Route::get('countries/listing', array('as' => 'listing_country','uses' => 'CountriesController@listing'));
  Route::get('countries/edit/{id}',array('as' => 'edit_country','uses' => 'CountriesController@edit'));
  Route::post('countries/update',array('as' => 'update_country','uses' => 'CountriesController@update'));
  Route::get('countries/add',array('as' => 'add_country','uses' => 'CountriesController@add'));
  Route::post('countries/store',array('as' => 'store_country','uses' => 'CountriesController@store'));
  Route::get('countries/{id}',array('as' => 'delete_country','uses' => 'CountriesController@destroy'));
  

  // State routes
  Route::get('states', array('as' => 'states','uses' => 'StatesController@index'));
  Route::get('states/listing', array('as' => 'listing_state','uses' => 'StatesController@listing'));
  Route::get('states/edit/{id}',array('as' => 'edit_state','uses' => 'StatesController@edit'));
  Route::post('states/update',array('as' => 'update_state','uses' => 'StatesController@update'));
  Route::get('states/add',array('as' => 'add_state','uses' => 'StatesController@add'));
  Route::post('states/store',array('as' => 'store_state','uses' => 'StatesController@store'));
  Route::get('states/{id}',array('as' => 'delete_state','uses' => 'StatesController@destroy'));
  

  // City routes
  Route::get('cities', array('as' => 'cities','uses' => 'CitiesController@index'));
  Route::get('cities/listing', array('as' => 'listing_city','uses' => 'CitiesController@listing'));
  Route::get('cities/edit/{id}',array('as' => 'edit_city','uses' => 'CitiesController@edit'));
  Route::post('cities/update',array('as' => 'update_city','uses' => 'CitiesController@update'));
  Route::get('cities/add',array('as' => 'add_city','uses' => 'CitiesController@add'));
  Route::post('cities/store',array('as' => 'store_city','uses' => 'CitiesController@store'));
  Route::get('cities/{id}',array('as' => 'delete_city','uses' => 'CitiesController@destroy'));
  

  // Sub City routes
  Route::get('sub_cities', array('as' => 'sub_cities','uses' => 'SubCitiesController@index'));
  Route::get('sub_cities/listing', array('as' => 'listing_sub_city','uses' => 'SubCitiesController@listing'));
  Route::get('sub_cities/edit/{id}',array('as' => 'edit_sub_city','uses' => 'SubCitiesController@edit'));
  Route::post('sub_cities/update',array('as' => 'update_sub_city','uses' => 'SubCitiesController@update'));
  Route::get('sub_cities/add',array('as' => 'add_sub_city','uses' => 'SubCitiesController@add'));
  Route::post('sub_cities/store',array('as' => 'store_sub_city','uses' => 'SubCitiesController@store'));
  Route::get('sub_cities/{id}',array('as' => 'delete_sub_city','uses' => 'SubCitiesController@destroy'));
  

  //Route::group(['middleware' => 'form.auth'], function() {
  Route::get('forms', array('as' => 'forms','uses' => 'FormsController@index'));
  Route::get('forms/listing', array('as' => 'listing_form','uses' => 'FormsController@listing'));
  Route::get('forms/edit/{id}',array('as' => 'edit_form','uses' => 'FormsController@edit'));
  Route::post('forms/update',array('as' => 'update_form','uses' => 'FormsController@update'));
  Route::get('forms/add',array('as' => 'add_form','uses' => 'FormsController@add'));
  Route::post('forms/store',array('as' => 'store_form','uses' => 'FormsController@store'));
  Route::get('forms/{id}',array('as' => 'delete_form','uses' => 'FormsController@destroy'));
  Route::get('attributes/add_edit/{id}',array('as' => 'add_edit_attribute','uses' => 'FormsController@addEditAttribute'));
  Route::post('attributes/save',array('as' => 'save_attribute','uses' => 'FormsController@saveAttribute'));
  Route::get('attributes/show/{id}',array('as' => 'show_attribute','uses' => 'FormsController@showAttribute'));
  
  // Job routes
  Route::get('jobs', array('as' => 'jobs','uses' => 'JobsController@index'));
  Route::get('jobs/listing', array('as' => 'listing_job','uses' => 'JobsController@listing'));
  Route::get('jobs/{id}',array('as' => 'delete_job','uses' => 'JobsController@destroy'));
  Route::get('block_job/{id}',array('as' => 'block_job','uses' => 'JobsController@block'));
  Route::get('feature_job/{id}',array('as' => 'feature_job','uses' => 'JobsController@feature'));
  Route::get('jobs/user_applied/{id}',array('as' => 'show_user_applied','uses' => 'JobsController@showAppliedUser'));
  
  Route::get('dashboards', array('as' => 'dashboards','uses' => 'DashboardsController@index'));

  Route::group(['middleware' => 'pages'], function() {
    Route::resource('pages', 'PagesController');
  });

  Route::resource('ads', 'AdsController');
  Route::resource('testimonials', 'TestimonialsController');
  Route::resource('announcements', 'AnnouncementsController');
  Route::resource('banners', 'BannersController');  
  
});