<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Dropbox\Client;

//Model
use App\Document as Document;
use App\DocumentOffice as DocumentOffice;
use App\DocumentState as DocumentState;
use Helpers;

class DocumentSendController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Document $document, DocumentOffice $document_office , 
                                DocumentState $document_state, Request $request)
    {
        //Instance
        $this->document=$document;
        $this->document_office = $document_office;
        $this->document_state = $document_state;
        //database get year
        $route=$request->route();
        $this->database = is_array($route) ?  Helpers::name_database($route[2]['year']) : 0;
        //Choose database
        try{$this->document->setConnection($this->database);
        }catch(\Exception $e){}
        try{$this->document_office->setConnection($this->database);
        }catch(\Exception $e){}
        try{$this->document_state->setConnection($this->database);
        }catch(\Exception $e){}
        //Get office id, user key
        $this->office_id = $request->header('office-id');
        $this->user_id = $request->header('user-id');
        //Conection to database view_table
        $this->conection=DB::connection($this->database);

    }
    
    /** Display a listing of the resource */
    public function index(Request $request){
        $request['office_id'] = $this->office_id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        
            try{
                //Query
                $results = DB::connection($this->database)
                    // ->table('view_office_users')
                    ->table('view_send_documents')
                    ->where('office_id',$data['office_id'])
                    ->where('active','S')
                    ->paginate(Helpers::number_paginate());
                //Response
                return response()->json($results,200);
            }
            catch(\Exception $e){return response()->json(['error'=>'Not Content'],404,[]);}  
         
    }
    /** Display the offices send from document*/
    public function show(Request $request,$id){
        //View
        $table_view='view_documents_offices';
        //Put paremeters headers in the array request
        $request['document_id'] = $id;
        // $request['office_id'] = $this->office_id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'document_id' => "required|integer|exists:$this->database.documents,id",
            // 'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);

        try{
            //Query
            $results=$this->conection 
                ->table($table_view)
                ->where ('document_id',$data['document_id'])
                // ->where ('office_id',$data['office_id'])
                ->paginate(Helpers::number_paginate());
            //Response
            return response()->json($results,200);
            }
        catch(\Exception $e){
            return $e;
            // return response()->json(['error'=>'Bad Request'],400,[]);
        }
        
    }
     /** Store a newly created resource array in storage*/
     public function store(Request $request){
        //Put paremeters headers in the array request
        $request['header_office_id'] = $this->office_id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'header_office_id'=> "required|integer|exists:$this->database.offices,id",
            'offices'=> "required|array",
            'offices.*'=> "integer|exists:$this->database.offices,id",// check each item in the array
            'document_id'=> "required|integer|exists:$this->database.documents,id",
            'state_id'=> "required|integer|exists:$this->database.states,id",
            'feedback'=> "required|max:200",
            // 'conclution_id'=> "required|integer|exists:$this->database.conclutions,id",
            // 'preference_id'=> "required|integer|exists:$this->database.preferences,id",
        ]);
        //Integrity table
        // $exist =  $this->document_office
        //         ->where ('document_id',$data['document_id'])
        //         ->where ('office_id',$data['office_id'])
        //         ->exists();
        //Validate if your office its the document own
        $permission =  $this->document
                ->where ('id',$data['document_id'])
                ->where ('office_id',$request['header_office_id'])
                ->exists();
        if(!$permission){
            return response()->json(['error'=>'No content'],403,[]);
        }

            try{
                $this->conection->getPdo()->beginTransaction();

                foreach ($data['offices']as $office) {
                    // code
                    $results= $this->document_office->create([
                        'office_id' => $office,
                        'document_id' => $data['document_id'],
                        'conclution_id' => 1,
                        'preference_id' => 1,
                    ]);
                }

                $results= $this->document_state->create([
                    'state_id' => $data['state_id'],
                    'document_id' => $data['document_id'],
                    'feedback' => $data['feedback']
                ]);
                // return $data;

                $this->conection->getPdo()->commit();
                return response()->json($results,200);
    
            }catch(\Exception $e){
                $this->conection->getPdo()->rollBack();
                return response()->json(['error'=>'Conflict'],409,[$e]);
            } 
    }

     /** Store a newly created resource in storage*/
     public function storeOne(Request $request){
        //Put paremeters headers in the array request
        $request['header_office_id'] = $this->office_id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'header_office_id'=> "required|integer|exists:$this->database.offices,id",
            'office_id'=> "required|integer|exists:$this->database.offices,id",// check each item in the array
            'document_id'=> "required|integer|exists:$this->database.documents,id",
        ]);
        
        $permission =  $this->document
                ->where ('id',$data['document_id'])
                ->where ('office_id',$request['header_office_id'])
                ->exists();
        if(!$permission){
            return response()->json(['error'=>'No content'],403,[]);
        }

            try{
                // code
                $results= $this->document_office->create([
                    'office_id' => $data['office_id'],
                    'document_id' => $data['document_id'],
                    'conclution_id' => 1,
                    'preference_id' => 1,
                ]);
                return response()->json($results,200);
    
            }catch(\Exception $e){
                return response()->json(['error'=>'Conflict'],409,[]);
            } 
    }
    /** Update the specified resource in storage*/
    public function update(Request $request, $id){
        
    }
    /** Remove the specified resource from storage*/
    public function destroy(Request $request,$id){
        
    }
}
