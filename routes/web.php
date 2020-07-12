<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
    
});

$router->get('/prueba', function(){
    //Default port 
    //$results = DB::connection()->select("SELECT * FROM delegations");
    //DB Especific
    $results = DB::connection('mysql2018')->select("SELECT * FROM delegations");
    //$results = DB::connection('mysql2019')->select("SELECT * FROM delegations");
    //$results  = DB::connection('mysql2019')->table('delegations')->get();
    return $results;
    //return response()->json($results,200);
});

 /**
  * officeauth: Permiso de oficina, partiendo del user-id
  * apikey: Validar que el  user-id, pertenezca al x-api-key
  * manager-secre: Valida que x-api-key tenga nivel de manager o secretary
  * year: Valida que se esté mandando un año válido
  */
  //versionamiento V1 : //http://sigeseback.com/api/sigese/v1/2018/delegations
  //remote: http://ideasencodigo.com/api/sigese/v1/2019/key
  $router->group(['middleware' => ['year'],'prefix'=> 'v1/{year}'], function () use ($router) {
  // $router->group(['middleware' => ['year','json'],'prefix'=> 'api/sigese/v1/{year}'], function () use ($router) {

    $router->get('/key', function () { return str_random(32);});
    
    $router->group(['middleware' => ['manager-secre','apikey','officeauth']], function () use ($router) {
      // $router->get('/delegations', ['uses' => 'DelegationController@index']);
    });
        #Catalogue tables
        //DELEGATIONS
          $router->get('/delegations', ['uses' => 'DelegationController@index']);
          $router->get('/delegations/{id}', ['uses' => 'DelegationController@show']);
          $router->post('/delegations', ['uses' => 'DelegationController@store']);
          $router->put('/delegations/{id}', ['uses' => 'DelegationController@update']);
          // $router->patch('/delegations', ['uses' => 'DelegationController@update']);
          $router->delete('/delegations/{id}', ['uses' => 'DelegationController@destroy']);
        //TYPES
          $router->get('/types', ['uses' => 'TypeController@index']);
          $router->get('/types/{id}', ['uses' => 'TypeController@show']);
          $router->post('/types', ['uses' => 'TypeController@store']);
          $router->put('/types/{id}', ['uses' => 'TypeController@update']);
          // $router->patch('/types', ['uses' => 'TypeController@update']);
          $router->delete('/types/{id}', ['uses' => 'TypeController@destroy']);
        //STATES
          $router->get('/states', ['uses' => 'StateController@index']);
          $router->get('/states/{id}', ['uses' => 'StateController@show']);
          $router->post('/states', ['uses' => 'StateController@store']);
          $router->put('/states/{id}', ['uses' => 'StateController@update']);
          // $router->patch('/states', ['uses' => 'StateController@update']);
          $router->delete('/states/{id}', ['uses' => 'StateController@destroy']);
        //PREFERENCES
          $router->get('/preferences', ['uses' => 'PreferenceController@index']);
          $router->get('/preferences/{id}', ['uses' => 'PreferenceController@show']);
          $router->post('/preferences', ['uses' => 'PreferenceController@store']); 
          $router->put('/preferences/{id}', ['uses' => 'PreferenceController@update']); 
          // $router->patch('/preferences', ['uses' => 'PreferenceController@update']); 
          $router->delete('/preferences/{id}', ['uses' => 'PreferenceController@destroy']);
        //LEVELS
          $router->get('/levels', ['uses' => 'LevelController@index']);
          $router->get('/levels/{id}', ['uses' => 'LevelController@show']);
          $router->post('/levels', ['uses' => 'LevelController@store']);  
          $router->put('/levels/{id}', ['uses' => 'LevelController@update']);  
          // $router->patch('/levels', ['uses' => 'LevelController@update']);  
          $router->delete('/levels/{id}', ['uses' => 'LevelController@destroy']);
        //CONCLUTIONS
          $router->get('/conclutions', ['uses' => 'ConclutionController@index']); 
          $router->get('/conclutions/{id}', ['uses' => 'ConclutionController@show']);
          $router->post('/conclutions', ['uses' => 'ConclutionController@store']);
          $router->put('/conclutions/{id}', ['uses' => 'ConclutionController@update']);
          // $router->patch('/conclutions', ['uses' => 'ConclutionController@update']);
          $router->delete('/conclutions/{id}', ['uses' => 'ConclutionController@destroy']);
        //TOWNS
          $router->get('/towns', ['uses' => 'TownController@index']);
          $router->get('/towns/{id}', ['uses' => 'TownController@show']);
          $router->post('/towns', ['uses' => 'TownController@store']);
          $router->put('/towns/{id}', ['uses' => 'TownController@update']);
          // $router->patch('/towns', ['uses' => 'TownController@update']);
          $router->delete('/towns/{id}', ['uses' => 'TownController@destroy']);

      #Tables
        //OFFICES
          $router->get('/offices', ['uses' => 'OfficeController@index']);
          $router->get('/offices/{id}', ['uses' => 'OfficeController@show']);
          $router->post('/offices', ['uses' => 'OfficeController@store']);
          $router->put('/offices/{id}', ['uses' => 'OfficeController@update']);
          // $router->patch('/offices', ['uses' => 'OfficeController@update']);
          $router->delete('/offices/{id}', ['uses' => 'OfficeController@destroy']);
        //CONTACTS (office-id)
          $router->get('/contacts', ['uses' => 'ContactController@index']);
          $router->get('/contacts/{id}', ['uses' => 'ContactController@show']);
          $router->post('/contacts', ['uses' => 'ContactController@store']);
          $router->put('/contacts/{id}', ['uses' => 'ContactController@update']);
          // $router->patch('/contacts', ['uses' => 'ContactController@update']);
          $router->delete('/contacts/{id}', ['uses' => 'ContactController@destroy']);
        //WORKERS  (office-id)
          $router->get('/workers', ['uses' => 'WorkerController@index']); 
          $router->get('/workers/{id}', ['uses' => 'WorkerController@show']); 
          $router->post('/workers', ['uses' => 'WorkerController@store']);
          $router->put('/workers/{id}', ['uses' => 'WorkerController@update']);
          // $router->patch('/workers', ['uses' => 'WorkerController@update']);
          $router->delete('/workers/{id}', ['uses' => 'WorkerController@destroy']);
        //USERS 
          $router->get('/users', ['uses' => 'UserController@index']);
          $router->get('/users/{id}', ['uses' => 'UserController@show']);
          $router->post('/users', ['uses' => 'UserController@store']);
          $router->put('/users/{id}', ['uses' => 'UserController@update']);
          // $router->patch('/users', ['uses' => 'UserController@update']);
          $router->post('/users/login', ['uses' => 'UserController@login']);
          $router->delete('/users/{id}', ['uses' => 'UserController@destroy']);
          //logout and reset
          $router->get('/logout', ['uses' => 'UserController@logout']);
          $router->get('/reset', ['uses' => 'UserController@reset']);
        //CALLS (office-id)
          $router->get('/calls', ['uses' => 'CallController@index']);
          $router->get('/calls/{id}', ['uses' => 'CallController@show']);
          $router->post('/calls', ['uses' => 'CallController@store']);
          $router->put('/calls/{id}', ['uses' => 'CallController@update']);
          // $router->patch('/calls', ['uses' => 'CallController@update']);
          $router->delete('/calls/{id}', ['uses' => 'CallController@destroy']);
        //EVENTS (office-id)
          $router->get('/events', ['uses' => 'EventController@index']);
          $router->get('/events/{id}', ['uses' => 'EventController@show']);
          $router->post('/events', ['uses' => 'EventController@store']);
          $router->put('/events/{id}', ['uses' => 'EventController@update']);
          // $router->patch('/events', ['uses' => 'EventController@update']);
          $router->delete('/events/{id}', ['uses' => 'EventController@destroy']);
        //DOCUMENTS (office-id)
        // DOCUMENTS
          $router->get('/documents', ['uses' => 'DocumentController@index']);
          $router->get('/documents/{id}', ['uses' => 'DocumentController@show']);
          $router->post('/documents', ['uses' => 'DocumentController@store']);
          $router->put('/documents/{id}', ['uses' => 'DocumentController@update']);
          // $router->patch('/documents', ['uses' => 'DocumentController@update']);
          $router->delete('/documents/{id}', ['uses' => 'DocumentController@destroy']);
          //funcional
          $router->post('/upload/{id}', ['uses' => 'DocumentController@storefile']);
          //ideal
          // $router->patch('/documents/{id}', ['uses' => 'DocumentController@storefile']);

       //FILTERS DOCUMENTS
  
        // DOCUMENTS_SENT
        $router->get('/documents_sent', ['uses' => 'DocumentSendController@index']);
        $router->get('/documents_sent_to/{id}', ['uses' => 'DocumentSendController@show']);
        $router->post('/documents_sent', ['uses' => 'DocumentSendController@store']);
        $router->post('/documents_sent_one', ['uses' => 'DocumentSendController@storeOne']);
        // DOCUMENTS_ELABORATED
        $router->get('/documents_elaborated', ['uses' => 'DocumentController@elaborated']);
        // DOCUMENTS_INBOX
        $router->get('/documents_inbox', ['uses' => 'DocumentInboxController@index']);
        $router->patch('/documents_inbox/{id}', ['uses' => 'DocumentInboxController@update']);
        // DOCUMENTS_RECEIVED
        $router->get('/documents_received', ['uses' => 'DocumentReceivedController@index']);
        $router->patch('/documents_received/{id}', ['uses' => 'DocumentReceivedController@update']);
        // DOCUMENTS_NOTIFIED
        $router->get('/documents_notified', ['uses' => 'DocumentNotifiedController@index']);
        $router->patch('/documents_notified/{id}', ['uses' => 'DocumentNotifiedController@update']);
        $router->put('/documents_notified/{id}', ['uses' => 'DocumentNotifiedController@updateOne']);
        // DOCUMENTS_EXECUTED
        $router->get('/documents_executed', ['uses' => 'DocumentExecutedController@index']);
        // DOCUMENTS_FINALISHED
        $router->get('/documents_finished', ['uses' => 'DocumentFinishedController@index']);
        $router->patch('/documents_finished/{id}', ['uses' => 'DocumentFinishedController@update']);

      #Details Table or Pivot
        //OFFICE-USER (Office administration)
          $router->get('/offices_users', ['uses' => 'OfficeUserController@index']);
          $router->get('/offices_users/{id}', ['uses' => 'OfficeUserController@show']);
          // $router->post('/offices_users', ['uses' => 'OfficeUserController@store']);
          $router->put('/offices_users/{id}', ['uses' => 'OfficeUserController@update']);
          $router->delete('/offices_users/{id}', ['uses' => 'OfficeUserController@destroy']);
        //DOCUMENT-OFFICE (Sending and receiving documents )
          $router->get('/documents_offices', ['uses' => 'DocumentOfficeController@index']);
          $router->get('/documents_offices/{id}', ['uses' => 'DocumentOfficeController@show']);
          // $router->get('/documents_offices_to', ['uses' => 'DocumentOfficeController@showOffice']);
          // $router->get('/documents_offices_to/{id}', ['uses' => 'DocumentOfficeController@showOfficeTo']);
          $router->post('/documents_offices', ['uses' => 'DocumentOfficeController@store']);
          // $router->put('/documents_offices/{id}', ['uses' => 'DocumentOfficeController@update']);
          $router->patch('/documents_offices/{id}', ['uses' => 'DocumentOfficeController@update']);
          $router->delete('/documents_offices/{id}', ['uses' => 'DocumentOfficeController@destroy']);

        //DOCUMENT-STATES  (Diferent states of the document)
          $router->get('/documents_states', ['uses' => 'DocumentStateController@index']);
          $router->get('/documents_states/{id}', ['uses' => 'DocumentStateController@show']);
          // $router->get('/documents_states_one/{id}', ['uses' => 'DocumentStateController@showOne']);
          $router->post('/documents_states', ['uses' => 'DocumentStateController@store']);
          // $router->put('/documents_states/{id}', ['uses' => 'DocumentStateController@update']);
          $router->delete('/documents_states/{id}', ['uses' => 'DocumentStateController@destroy']);
          
        //DOCUMENT-OFFICES-STATES  (Diferent states of the document)
          $router->get('/documents_offices_states', ['uses' => 'DocumentOfficeStateController@index']);
          $router->get('/documents_offices_states/{id}', ['uses' => 'DocumentOfficeStateController@show']);
          // $router->get('/documents_offices_states_one/{id}', ['uses' => 'DocumentOfficeStateController@showOne']);
          
          $router->post('/documents_offices_states', ['uses' => 'DocumentOfficeStateController@store']);
          // $router->put('/documents_offices_states/{id}', ['uses' => 'DocumentOfficeStateController@update']);
          $router->delete('/documents_offices_states/{id}', ['uses' => 'DocumentOfficeStateController@destroy']);
        
        //DOCUMENT-WORKER (Set responsibilities)
          $router->get('/documents_offices_workers', ['uses' => 'DocumentOfficeWorkerController@index']);
          $router->get('/documents_offices_workers/{id}', ['uses' => 'DocumentOfficeWorkerController@show']);
          $router->post('/documents_offices_workers', ['uses' => 'DocumentOfficeWorkerController@store']);
          // $router->put('/documents_offices_workers/{id}', ['uses' => 'DocumentOfficeWorkerController@update']);
          $router->delete('/documents_offices_workers/{id}', ['uses' => 'DocumentOfficeWorkerController@destroy']);

        //MAIL
          // $router->get('/mail', ['uses' => 'MailController@store']);
  });//End to Versioning