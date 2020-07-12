<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//Model
// use App\Document as Document;
use App\DocumentOffice as DocumentOffice;
use App\DocumentOfficeState as DocumentOfficeState;
use Helpers;

class DocumentFinishedController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, DocumentOffice $document_office, DocumentOfficeState $document_office_state)
    {
        //Instance
        $this->document_office = $document_office;
        $this->document_office_state = $document_office_state;
        //database get year
        $route=$request->route();
        $this->database = is_array($route) ?  Helpers::name_database($route[2]['year']) : 0;
        //Choose database
        try{$this->document_office->setConnection($this->database);
        }catch(\Exception $e){}
        try{$this->document_office_state->setConnection($this->database);
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
        $view = 'view_documents_finished';
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

    /** Update the specified resource in storage for notified */
    public function update(Request $request, $id){
        //Put paremeters headers in the array request
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.document_offices,id",
            'conclution_id'=> "required|integer|exists:$this->database.conclutions,id",
            'state_id'=> "required|integer|exists:$this->database.states,id",
            'feedback'=> "required|max:200",
        ]);
        
        try {

            $this->conection->getPdo()->beginTransaction();
            // database queries here
            $row=$this->document_office->findOrFail($id);
            $results= $row ->update([
                'conclution_id' => $data['conclution_id'],
            ]);

            $results= $this->document_office_state->create([
                'document_office_id' => $data['id'],
                'state_id' => $data['state_id'],
                'feedback' => $data['feedback'],
            ]);

            $this->conection->getPdo()->commit();
            return response()->json($row,200);
        }
        catch(\Exception $e){
            $this->conection->getPdo()->rollBack();
            return response()->json(['error'=>'Bad Request'],400,[]);
        }

       
    }
    
}
