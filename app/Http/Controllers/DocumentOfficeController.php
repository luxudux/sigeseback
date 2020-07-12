<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//Model
use App\DocumentOffice as DocumentOffice;
use App\Document as Document;
use Helpers;

class DocumentOfficeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DocumentOffice $document_office, Document $document, Request $request)
    {
        //Instance
        $this->document_office = $document_office;
        $this->document = $document;
        //database get year
        $route=$request->route();
        $this->database = is_array($route) ?  Helpers::name_database($route[2]['year']) : 0;
        //Choose database
        try{$this->document_office->setConnection($this->database);
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
        //Find Register whit office_id and user_id
        $exist = $this->conection 
                    ->table('view_documents_offices')
                    ->where ('office_id',$data['office_id'])
                    ->exists(); 
        if($exist){
            try{
                //Query
                $results =$this->conection 
                            ->table('view_documents_offices')
                            ->where('office_id',$data['office_id'])
                            ->paginate(Helpers::number_paginate());
                //Response
                return response()->json($results,200);
            }
            catch(\Exception $e){return response()->json(['error'=>'Conflict'],409,[]);}
        }
        return response()->json(['error'=>'Not Content'],404,[]);     
    }
    /** Display the specified resource */
    public function show(Request $request,$id){
        //View
        $table_view='view_documents_offices';
        //Put paremeters headers in the array request
        $request['id'] = $id;
        $request['office_id'] = $this->office_id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.document_offices,id",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);

        //return $data['id'];
        //return $data['office_id'];
        //Find Register whit office_id and user_id
        $exist = $this->conection 
                    ->table($table_view)
                    ->where ('document_id',$data['id'])
                    ->where ('office_id',$data['office_id'])
                    ->exists();
        if($exist){
            try{
                //Query
                $results=$this->conection 
                    ->table($table_view)
                    ->where ('document_id',$data['id'])
                    ->where ('office_id',$data['office_id'])
                    ->paginate(Helpers::number_paginate());
                //Response
                return response()->json($results,200);
            }
            catch(\Exception $e){return response()->json(['error'=>'Bad Request'],400,[]);}
        }
        return response()->json(['error'=>'Not Content'],404,[]); 
    }
    
    /** Update the specified resource in storage*/
    public function update(Request $request, $id){
       
        //Put paremeters headers in the array request
        $request['header_office_id'] = $this->office_id;
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'header_office_id'=> "required|integer|exists:$this->database.offices,id",
            'id' => "required|integer|exists:$this->database.document_offices,id",
            // 'office_id'=> "required|integer|exists:$this->database.offices,id",
            // 'document_id'=> "required|integer|exists:$this->database.documents,id",
            'conclution_id'=> "required|integer|exists:$this->database.conclutions,id",
            'preference_id'=> "required|integer|exists:$this->database.preferences,id",
        ]);
        // Get de document id
        $id_doc = $this->document_office->findOrFail($id)->document_id;

        //Validate if your office its the document own
        $permission =  $this->document
                ->where ('id',$id_doc)
                ->where ('office_id',$request['header_office_id'])
                ->exists();
        if(!$permission){
            return response()->json(['error'=>'No content'],403,[]);
        }

        if($permission){
            try{
                $row=$this->document_office->findOrFail($id);
                $results= $row ->update([
                    // 'office_id' => $data['office_id'],
                    // 'document_id' => $data['document_id'],
                    'conclution_id' => $data['conclution_id'],
                    'preference_id' => $data['preference_id'],
                ]);
                return response()->json($results,200);

            }catch(\Exception $e){return response()->json(['error'=>'Conflict'],409,[]);} 
        }
        return response()->json(['error'=>'Conflict'],409,[]); 




         
    }
    /** Remove the specified resource from storage*/
    public function destroy(Request $request,$id){
        //Put paremeters headers in the array request
        $request['header_office_id'] = $this->office_id;
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'header_office_id'=> "required|integer|exists:$this->database.offices,id",
            'id' => "required|integer|exists:$this->database.document_offices,id",
        ]);

        //Get document_id
        $document_id=$this->document_office->findOrFail($request['id'])->document_id;

        //Validate if your office its the document own
        $permission =  $this->document
                ->where ('id',$document_id)
                ->where ('office_id',$request['header_office_id'])
                ->exists();
        if(!$permission){
            return response()->json(['error'=>'No content'],403,[]);
        }

        //Query
        try{
            $results = $this->document_office->findOrFail($id);
            $results->delete();
            //Response
            if($results){return response()->json($results,200);}
        }catch(\Exception $e){return response()->json(['error'=>'No Content'],406,[]);}

    }
}
