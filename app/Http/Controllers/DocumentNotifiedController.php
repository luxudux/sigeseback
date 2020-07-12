<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//Model
// use App\Document as Document;
use App\DocumentOfficeState as DocumentOfficeState;
use App\DocumentOfficeWorker as DocumentOfficeWorker;
use Helpers;

class DocumentNotifiedController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request,  DocumentOfficeWorker $document_office_worker, DocumentOfficeState $document_office_state)
    {
        //Instance
        $this->document_office_worker = $document_office_worker;
        $this->document_office_state = $document_office_state;
        //database get year
        $route=$request->route();
        $this->database = is_array($route) ?  Helpers::name_database($route[2]['year']) : 0;
        //Choose database
        try{$this->document_office_state->setConnection($this->database);
        }catch(\Exception $e){}
        try{$this->document_office_worker->setConnection($this->database);
        }catch(\Exception $e){}
        //Get office id, user key
        $this->office_id = $request->header('office-id');
        $this->user_id = $request->header('user-id');
        //Conection to database view_table
        $this->conection=DB::connection($this->database);
    }
    /** Display a listing of the resource */
    public function index(Request $request){
        //Put paremeters headers in the array request
        $request['office_id'] = $this->office_id;
        $view = 'view_documents_notified';
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
            try{
                //Query
                $results =$this->conection 
                            ->table($view)
                            ->where('office_id',$data['office_id'])
                            // ->where('active', 'S')
                            // ->where('notificado', '1')
                            // ->where('delegado', '0')
                            // ->where('finalizado', '0')
                            ->paginate(Helpers::number_paginate());
                //Response
                return response()->json($results,200);
            }
            catch(\Exception $e){return response()->json(['error'=>'Conflict'],409,[]);}   
    }

     /** Update the specified array of resource in storage for notified */
     public function update(Request $request, $id){
        //Put paremeters headers in the array request
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.document_offices,id",
            'workers'=> "required|array",
            'workers.*'=> "integer|exists:$this->database.workers,id",// check each item in the array
            'state_id'=> "required|integer|exists:$this->database.states,id",
            'feedback'=> "required|max:200",
        ]);
        
        // Query
        try {

            $this->conection->getPdo()->beginTransaction();
            // database queries here
            foreach ($data['workers']as $worker) {
                // code
                $results= $this->document_office_worker->create([
                    'document_office_id' => $data['id'],
                    'worker_id' => $worker,
                ]);
            }
            
            $results= $this->document_office_state->create([
                'document_office_id' => $data['id'],
                'state_id' => $data['state_id'],
                'feedback' => $data['feedback'],
            ]);

            $this->conection->getPdo()->commit();
            return response()->json($results,200);
        }
        catch(\Exception $e){
            $this->conection->getPdo()->rollBack();
            return response()->json(['error'=>'Bad Request'],400,[]);
        }

       
    }
    /** Update the specified one resource in storage for notified */
    public function updateOne(Request $request, $id){
        //Put paremeters headers in the array request
        $request['id'] = $id;
        // $request['workers_last'] = last($request['workers']); //last item array
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.document_offices,id",
            'worker_id'=> "integer|required|exists:$this->database.workers,id",// check each item in the array
        ]);
        
        // Query
        try {
            // database queries here
            $results= $this->document_office_worker->create([
                'document_office_id' => $data['id'],
                'worker_id' => $data['worker_id'],
            ]);
            return response()->json($results,200);
        }
        catch(\Exception $e){
            // return $e;
            return response()->json(['error'=>'Bad Request'],400,[]);
        }
 
    }
    
}
