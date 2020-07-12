<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//Model
// use App\Document as Document;
use Helpers;

class DocumentExecutedController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        //Instance
        // $this->document = $document;
        //database get year
        $route=$request->route();
        $this->database = is_array($route) ?  Helpers::name_database($route[2]['year']) : 0;
        //Choose database
        // try{$this->document->setConnection($this->database);
        // }catch(\Exception $e){}
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
        $view = 'view_documents_executed';
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
    
}
