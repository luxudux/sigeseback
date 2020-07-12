<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//Model
use App\DocumentState as DocumentState;
use App\Document as Document;
use Helpers;

class DocumentStateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DocumentState $document_state, Document $document, Request $request)
    {
        //Instance
        $this->document_state = $document_state;
        $this->document = $document;
        //database get year
        $route=$request->route();
        $this->database = is_array($route) ?  Helpers::name_database($route[2]['year']) : 0;
        //Choose database
        try{$this->document_state->setConnection($this->database);
        }catch(\Exception $e){}
        try{$this->document->setConnection($this->database);
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
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        $table_view="view_documents_states";
        //Find Register 
        $exist = $this->conection 
                    ->table($table_view)
                    ->where ('document_id',$data['office_id'])
                    ->exists(); 
        if($exist){
            try{
                //Query
                $results =$this->conection 
                            ->table($table_view)
                            ->where('document_office_id',$data['office_id'])
                            ->paginate(Helpers::number_paginate());
                //Response
                return response()->json($results,200);
            }
            catch(\Exception $e){return response()->json(['error'=>'Conflict'],409,[]);}
        }
        return response()->json(['error'=>'Not Content'],404,[]);     
    }
    /** Store a newly created resource in storage*/
    public function store(Request $request){
        //Put paremeters headers in the array request
        // $request['office_id'] = $this->office_id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'document_id'=> "required|integer|exists:$this->database.documents,id",
            'state_id'=> "required|integer|exists:$this->database.states,id",
            'feedback'=> "required|max:200",
        ]);
        // //Integrity table
        // $exist =  $this->document_state
        //         ->where ('document_id',$data['document_id'])
        //         ->where ('state_id',$data['state_id'])
        //         ->exists();

        //Validate if your office its the document own
        // $permission =  $this->document
        //         ->where ('id',$data['document_id'])
        //         ->where ('document_id',$data['document_id'])
        //         ->exists();

        // if(!$permission){
        //     return response()->json(['error'=>'No content'],403,[]);
        // }
        
        // if(!$exist){
            try{
                //Data set
                $results= $this->document_state->create([
                'state_id' => $data['state_id'],
                'document_id' => $data['document_id'],
                'feedback' => $data['feedback']
                ]);
                return response()->json($results,200);
    
            }catch(\Exception $e){return response()->json(['error'=>'Conflict',
            'excepción' => $e],409,[]);} 
        // }
        // return response()->json(['error'=>'Conflict'],409,[]); 
        
    }
    /** Display the specified resource */
    public function show(Request $request,$id){
        //View
        $table_view='view_document_states';
        //Put paremeters headers in the array request
        $request['id'] = $id;
        // $request['office_id'] = $this->office_id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.documents,id",
        ]);
        
        try{
          //Query
          $results=$this->conection 
              ->table($table_view)
              ->where ('document_id',$data['id'])
              ->orderBy('id', 'ASC')
              ->paginate(Helpers::number_paginate());
           //Response
           return response()->json($results,200);
         }
         catch(\Exception $e){return response()->json(['error'=>'Bad Request'],400,[]);}

    }
    /** Display the specified resource */
    // public function showOne(Request $request,$id){
    //     //View
    //     $table_view='view_document_states';
    //     //Put paremeters headers in the array request
    //     $request['id'] = $id;
    //     // $request['office_id'] = $this->office_id;
    //     //Validate Data and Get dates request 
    //     $data= $this->validate($request,[
    //         'id' => "required|integer|exists:$this->database.document_states,id",
    //         'document_id'=> "required|integer|exists:$this->database.documents,id",
    //     ]);
    //     //Validate if your office its the document own
    //     $permission =  $this->document
    //             ->where ('id',$data['id'])
    //             ->where ('document_id',$data['document_id'])
    //             ->exists();
        
    //     if(!$permission){
    //             return response()->json(['error'=>'No content'],403,[]);
    //     }
    //     $exist = $this->conection 
    //                 ->table($table_view)
    //                 ->where ('document_id',$data['id'])
    //                 ->exists();
    //     if($exist){
    //         try{
    //             //Query
    //             $results=$this->conection 
    //                     ->table($table_view)
    //                     ->where ('document_id',$data['id'])
    //                     ->paginate(Helpers::number_paginate());
    //             //Response
    //             return response()->json($results,200);
    //         }
    //         catch(\Exception $e){return response()->json(['error'=>'Bad Request'],400,[]);}
    //     }
    //     return response()->json(['error'=>'Not Content'],404,[]); 
    // }
    /** Update the specified resource in storage*/
    public function update(Request $request, $id){
       
         
    }
    /** Remove the specified resource from storage*/
    public function destroy(Request $request,$id){
        //Put paremeters headers in the array request
        $request['office_id'] = $this->office_id;
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.document_states,id",
        ]);

        //Query
        try{
            $results = $this->document_state->findOrFail($id);
            $results->delete();
            //Response
            if($results){return response()->json($results,200);}
        }catch(\Exception $e){return response()->json(['error'=>'No Content'],406,[]);}

    }
}
