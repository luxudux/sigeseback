<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Dropbox\Client;

//Model
use App\Document as Document;
use App\DocumentState as DocumentState;
use Helpers;

class DocumentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Document $document, DocumentState $document_state, Request $request)
    {
        //Instance
        $this->document=$document;
        $this->document_state = $document_state;
        //database get year
        $route=$request->route();
        $this->database = is_array($route) ?  Helpers::name_database($route[2]['year']) : 0;
        //Choose database
        try{$this->document->setConnection($this->database);
        }catch(\Exception $e){}
        try{$this->document_state->setConnection($this->database);
        }catch(\Exception $e){}
        //Get office id, user key
        $this->office_id = $request->header('office-id');
        $this->user_id = $request->header('user-id');
        //Conection to database view_table
        $this->conection=DB::connection($this->database);

    }
    /** VIEWS Display a listing of the resource*/
    public function listElaborate(Request $request){
        
        //View
        $table_view='view_elaborated_documents';
        //Put paremeters headers in the array request
        $request['office_id'] = $this->office_id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        
            try{
                $results =$this->conection 
                ->table($table_view)
                // ->where('d_office_id',$data['office_id'])
                // ->orderBy('document_office_id', 'DESC')
                ->paginate(Helpers::number_paginate());
                //Response
                return response()->json($results,200);
            }
            catch(\Exception $e){return response()->json(['error'=>'Not Content'],404,[]);}
        
    }
    /* DOCUMENT ELABORATED */
    public function elaborated(Request $request){
        
        $request['office_id'] = $this->office_id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        
            try{
                //Query
                $results = DB::connection($this->database)
                    // ->table('view_office_users')
                    ->table('view_elaborated_documents')
                    ->where('office_id',$data['office_id'])
                    ->where('active','S')
                    ->paginate(Helpers::number_paginate());
                //Response
                return response()->json($results,200);
            }
            catch(\Exception $e){return response()->json(['error'=>'Not Content'],404,[]);}  
    }

    /** Display a listing of the resource */
    public function index(Request $request){
        
        # Muestra la conclusión que tiene un documento
        // $results = $this->document->find(1)->conclution;
        # Muestra la preferencia que tiene un documento
        // $results = $this->document->find(1)->preference;
        # Muestra el centro de trabajo que emitió el documento
        // $results = $this->document->find(1)->office;
        # Muestra el usuario que creó el documento
        // $results = $this->document->find(1)->user;
        # Muestra todos los trabajadores que ejecutarán este documento
        // $results = $this->document->find(1)->workers;
        # Pivot: Muestra los estados que tiene este documento
        // $results = $this->document->find(1)->states;
        # Pivot: Muestra todas las officinas que recivieron un documento po id del documento
        // $results = $this->document->find(1)->off_receivers;
        //Query
        //Put paremeters headers in the array request
        $request['office_id'] = $this->office_id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        //Find Register whit office_id
        // $exist = $this->document->where ('active','S')
        //                     ->where ('office_id',$data['office_id'])
        //                     ->exists();
        // // Exist row;
        // if($exist){
            try{
                $results = $this->document
                ->where('office_id',$data['office_id'])
                ->where('active','S')
                ->paginate(Helpers::number_paginate());
                //Response
                return response()->json($results,200);
            }
            catch(\Exception $e){return response()->json(['error'=>'Not Content'],404,[]);}
        // }
        // return response()->json(['error'=>'Not Content'],404,[]);
        
    }
    /** Upload files to ftp */
    public function storefile(Request $request, $id){
       
        $request['id'] = $id;
        $request['office_id'] = $this->office_id;
        //Validando el archivo pdf
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.documents,id",
            'file'=> "required|mimes:pdf|max:10000",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        //Find Register whit office_id
        $exist = $this->document->where ('id',$id)
                    ->where ('office_id',$data['office_id'])
                    ->where ('active','S')
                    ->exists();
                    // Exist row;
        if($exist){
            // Query
            try{
                $dir=Helpers::directory_file($request->year);
                $url=Storage::disk('ftp')->put($dir, $data['file']);
                //$url= Storage::disk('dropbox')->put($dir, $request['file']);
                $row=$this->document->findOrFail($id);
                $results= $row ->update([
                    
                    'url' => $url
                ]);
                return response()->json($row,200);
            }
            catch(\Exception $e){return response()->json(['error'=>'Bad Request'],400,[]);}
        }
        return response()->json(['error'=>'Not Content'],404,[]);

    }
    /** Store a newly created resource in storage*/
    public function store(Request $request){
        //Put paremeters headers in the array request
        $request['office_id'] = $this->office_id;
        $request['user_id'] = $this->user_id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'subject'=> "required|max:50",
            'control'=> "required|max:30",
            'expiration'=> 'required|date_format:Y-m-d H:i:s',
            'type_id'=> "required|integer|exists:$this->database.types,id",
            // 'conclution_id'=> "required|integer|exists:$this->database.conclutions,id",
            // 'preference_id'=> "required|integer|exists:$this->database.preferences,id",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
            'user_id'=> "required|integer|exists:$this->database.users,id",

            'state_id'=> "required|integer|exists:$this->database.states,id",
            'feedback'=> "required|max:200",
        ]);
        try{

            $this->conection->getPdo()->beginTransaction();

            //Data set
            $results= $this->document->create([
                'subject' => $data['subject'],
                'control' => $data['control'],
                'expiration' => $data['expiration'],
                'type_id' => $data['type_id'],
                // 'conclution_id' => $data['conclution_id'],
                // 'preference_id' => $data['preference_id'],
                'office_id' => $data['office_id'],
                'user_id' => $data['user_id']

            ]);

            $results= $this->document_state->create([
                'state_id' => $data['state_id'],
                'state_id' => 1,
                'document_id' => $results->id,
                'feedback' => $data['feedback']
            ]);

            $this->conection->getPdo()->commit();
            return response()->json($results,201);
        }
        catch(\Exception $e){
            $this->conection->getPdo()->rollBack();
            return response()->json(['error'=>'Conflict'],409,[]);
        } 
    }
    /** Display the specified resource */
    public function show(Request $request,$id){
        //Put paremeters headers in the array request
        $request['office_id'] = $this->office_id;
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.documents,id",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
         //Find Register whit office_id
         $exist = $this->document->where ('id',$id)
                        ->where ('office_id',$data['office_id'])
                        ->where ('active','S')
                        ->exists();
        // Exist row;
        if($exist){
            // Query
            try{
                $results = $this->document->findOrFail($id);
                return response()->json($results,200);
            }
            catch(\Exception $e){return response()->json(['error'=>'Bad Request'],400,[]);}
        }
        return response()->json(['error'=>'Not Content'],404,[]); 
    }
    /** Update the specified resource in storage*/
    public function update(Request $request, $id){
        //Put paremeters headers in the array request
        $request['office_id'] = $this->office_id;
        $request['user_id'] = $this->user_id;
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.documents,id",
            'subject'=> "required|max:50",
            'control'=> "required|max:30",
            'url'=> "required|max:150",
            'expiration'=> 'required|date_format:Y-m-d H:i:s',
            'type_id'=> "required|integer|exists:$this->database.types,id",
            // 'conclution_id'=> "required|integer|exists:$this->database.conclutions,id",
            // 'preference_id'=> "required|integer|exists:$this->database.preferences,id",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
            'user_id'=> "required|integer|exists:$this->database.users,id",
        ]);
        //Find Register whit office_id
        $exist = $this->document->where ('id',$id)
                        ->where ('office_id',$data['office_id'])
                        ->where ('active','S')
                        ->exists();
        // Exist row;
        if($exist){
            // Query
            try{
                $row=$this->document->findOrFail($id);
                $results= $row ->update([
                    'subject' => $data['subject'],
                    'control' => $data['control'],
                    'url' => $data['url'],
                    'expiration' => $data['expiration'],
                    'type_id' => $data['type_id'],
                    // 'conclution_id' => $data['conclution_id'],
                    // 'preference_id' => $data['preference_id'],
                ]);
                return response()->json($row,200);
            }
            catch(\Exception $e){return response()->json(['error'=>'Bad Request'],400,[]);}
        } 
        return response()->json(['error'=>'Not Content'],404,[]); 
    }
    /** Remove the specified resource from storage*/
    public function destroy(Request $request,$id){
        //Put paremeters headers in the array request
        $request['office_id'] = $this->office_id;
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.documents,id",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        //Find Register whit office_id
        $exist = $this->document->where ('id',$id)
                        ->where ('office_id',$data['office_id'])
                        ->exists();
        // Exist row;
        if($exist){
            try{
                //Query
                $row = $this->document->findOrFail($id);
                $results= $row->update(['active' => 'N']);
                 //Response
                return response()->json($results,200);
            }catch(\Exception $e){return response()->json(['error'=>'No Content'],406,[]);}
        }
        return response()->json(['error'=>'Not Content'],404,[]); 
    }
}
