<?php



Route::group(['module' => 'client', 'namespace' => 'App\Modules\client\Controllers'], function() {

	Route::post('/get_list', array('uses' =>'LoginController@get_list'));

	Route::group(['middleware' => 'web'], function() {
		
		//Home routes
		Route::get('/', array('uses' =>'HomeController@index'));
		Route::get('/',  array('uses' =>'HomeController@index', 'as' => 'home'));
		Route::get('map', array('uses' =>'HomeController@welcome', 'as'=>'map'));		
		Route::get('home', array('uses' =>'HomeController@index', 'as' => 'home'));
		Route::get('jobs_listing', array('uses' =>'HomeController@jobListing', 'as' => 'all_jobs'));
		Route::get('users', array('uses' =>'HomeController@users', 'as' => 'all_users'));
		Route::get('home/listing', array('uses' =>'HomeController@listing', 'as' => 'job_listing'));
		Route::get('home/user_listing', array('uses' =>'HomeController@user_listing', 'as' => 'user_listing'));
		Route::get('home/user_detail/{id}', array('uses'=>'HomeController@userDetail', 'as' => 'user_detail'));
		Route::get('home/radial_search', array('uses' =>'HomeController@radialSearch', 'as' => 'radial_search'));
		Route::get('home/job_radial_search', array('uses' =>'HomeController@jobRadialSearch', 'as' => 'job_radial_search'));
		Route::get('home/categories_listing', array('uses' =>'HomeController@categorieListing', 'as' => 'all_categories'));
		Route::get('home/categories/listing', array('uses' =>'HomeController@categoryListing', 'as' => 'categorie_listing'));
		Route::get('home/job_detail/{id}', array('uses' =>'HomeController@jobDetail', 'as' => 'job_detail'));
		Route::get('home/{slug}', array('uses' =>'HomeController@homePages', 'as' => 'home_pages'));
		Route::get('home/jobs_listing/countries/{slug}', array('as' => 'search_jobs_by_country','uses' => 'HomeController@searchJobsByCountry'));
		Route::get('home/jobs_listing/categories/{slug}', array('as' => 'search_jobs_by_categorie','uses' => 'HomeController@searchJobsByCategory'));

		//Login routes
		Route::get('login', array('uses' =>'LoginController@login', 'as' => 'login_client'));
		Route::post('login/store', array('uses' =>'LoginController@loginStore', 'as' => 'loginStore'));
		Route::get('register', array('uses' =>'LoginController@register', 'as' => 'register'));
		Route::post('register/store', array('uses' =>'LoginController@registerStore', 'as' => 'registerStore'));
		Route::get('register/verification/{token}', array('uses' =>'LoginController@verification', 'as' => 'verification'));
		Route::get('forgot_password', array('uses' =>'LoginController@forgotPassword', 'as' => 'forgot_password'));
		Route::post('send_mail', array('uses' =>'LoginController@sendMail', 'as' => 'send_mail'));
		Route::get('send_mail/{token}', array('uses' =>'LoginController@passwordVerification', 'as' => 'password_verification'));
		Route::post('reset_password', array('uses' =>'LoginController@resetPassword', 'as' => 'reset_password'));
		Route::get('logout', array('uses' =>'LoginController@logout', 'as' => 'logout'));
	  	
		Route::group(['middleware' => 'client.auth'], function() {
	  	//Dashboard routes
	  	Route::get('dashboard/profile', array('as' => 'client_user_profile','uses' => 'DashboardsController@index'));
  		Route::get('dashboard/edit_profile',array('as' => 'edit_profile','uses' => 'DashboardsController@edit'));
  		Route::post('dashboard/update',array('as' => 'update_profile','uses' => 'DashboardsController@update'));
  		Route::get('dashboard/resume_list', array('as' => 'resume_list','uses' => 'DashboardsController@resumeList'));
  		Route::post('dashboard/resume_update', array('as'=>'update_resume', 'uses' =>'DashboardsController@updateResume'));
  		Route::get('dashboard/resume_list/{id}',array('as' => 'delete_resume','uses' => 'DashboardsController@destroyResume'));
  		Route::get('dashboard/job_applied', array('as' => 'user_job_applied','uses' => 'DashboardsController@jobApplied'));
		Route::get('show_contract/{id}', array('as'=>'show_contract', 'uses' =>'DashboardsController@showContract'));
		
  		Route::get('dashboard/job_posted', array('as' => 'user_job_posted','uses' => 'DashboardsController@jobPosted'));
  		Route::get('dashboard/download/{id}', array('as' => 'download_file','uses' => 'DashboardsController@getDownload'));
  		Route::post('dashboard/job_apply', array('as'=>'job_apply', 'uses' =>'DashboardsController@jobApply'));
  		Route::get('dashboard/user_applied/{slug}', array('as' => 'job_user_applied','uses' => 'DashboardsController@userApplied'));
  		Route::get('dashboard/user_resume/{path}', array('as' => 'download_resume','uses' => 'DashboardsController@getResume'));
  		Route::get('dashboard/invitation_accepted/{id}',array('as' => 'invitation_accepted','uses' => 'DashboardsController@acceptInvitation'));
  		Route::post('dashboard/accept_job',array('as' => 'accept_job','uses' => 'DashboardsController@acceptJob'));
  		Route::get('dashboard/invite_job/{id}',array('as' => 'invite_job','uses' => 'DashboardsController@inviteJob'));
  		Route::post('dashboard/send_contract',array('as' => 'send_contract','uses' => 'DashboardsController@sendContract'));
  		Route::get('dashboard/award_job/{id}',array('as' => 'award_job','uses' => 'DashboardsController@awardJob'));
  		Route::get('dashboard/cancel_job/{id}',array('as' => 'cancel_job','uses' => 'DashboardsController@cancelJob'));
		Route::post('dashboard/complete_job',array('as' => 'complete_job','uses' => 'DashboardsController@completeJob'));
		
		Route::get('dashboard/user_chat', array('as' => 'user_chat', 'uses' =>'DashboardsController@userChat'));
		Route::get('dashboard/all_messages', array('as' => 'all_messages', 'uses' =>'DashboardsController@allMessages'));
  		
  		//Job Post routes
  		Route::get('job_post', array('as' => 'job_post','uses' => 'JobPostsController@index'));
  		Route::get('job_post/add',array('as' => 'add_job_post','uses' => 'JobPostsController@add'));

  		Route::get('job_post/edit/{slug}',array('as' => 'edit_job_post','uses' => 'JobPostsController@add'));
  		Route::post('job_post/store',array('as' => 'store_job_post','uses' => 'JobPostsController@store'));
  		Route::post('job_post/update',array('as' => 'update_job_post','uses' => 'JobPostsController@update'));
		Route::get('job_post/get_states',array('as' => 'get_states', 'uses' => 'JobPostsController@getStates'));
		
		//Chat Routes
  		Route::get('chat-room-seeker',array('as' => 'chat_room_seeker', 'uses' => 'DashboardsController@chatRoomSeeker'));
		Route::get('get-chat-seeker/{user_id}/{job_id}/{poster_id}',array('as' => 'get_chat_seeker', 'uses' => 'DashboardsController@getChatSeeker'));
		
		Route::get('chat-room-employer',array('as' => 'chat_room_employer', 'uses' => 'DashboardsController@chatRoomEmployer'));
		Route::get('get-chat-employer/{user_id}/{job_id}/{poster_id}',array('as' => 'get_chat_employer', 'uses' => 'DashboardsController@getChatEmployer'));
		
		Route::post('send_message',array('as' => 'send_message','uses' => 'DashboardsController@sendMessage'));
		
		
  		});

	});

});