<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//Model
use App\Worker as Worker;
use Helpers;

class WorkerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Worker $worker, Request $request)
    {
        //Instance
        $this->worker = $worker;
        //database get year
        $route=$request->route();
        $this->database = is_array($route) ?  Helpers::name_database($route[2]['year']) : 0;
        //Choose database
        try{$this->worker->setConnection($this->database);
        }catch(\Exception $e){}
        //Get office id
        $this->office_id = $request->header('office-id');
    }
    /** Display a listing of the resource */
    public function index(Request $request){
        # Regresa todos los usuarios que tiene segun id del trabajador
        // $results = $worker->find(3)->users;
        # Regresa todos los trabajadores que van a ejecutar accion en el documento.
        // $results = $worker->find(4)->documents;
        //Put paremeters headers in the array request
        $request['office_id'] = $this->office_id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        //Find Register whit office_id
        $exist = $this->worker
                            ->where ('office_id',$data['office_id'])
                            ->exists();
        // Exist row;
        // if($exist){
            try{
                //Query
                $results = $this->worker
                ->where('office_id',$this->office_id)
                ->paginate(Helpers::number_paginate());
                //Response
                return response()->json($results,200); 
            } 
            catch(\Exception $e){return response()->json(['error'=>'Bad Request'],400,[]);}
        // }
        // return response()->json(['error'=>'Not Content'],404,[]);  
           
    }
    /** Store a newly created resource in storage*/
    public function store(Request $request){
        //Put paremeters headers in the array request
        $request['office_id'] = $this->office_id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'name'=> "required|max:60",
            'surname'=> 'required|max:60',
            'mail'   => "required|max:30|email|unique:$this->database.workers,mail",
            'sex'    => "required|in:H,M",
            'active'    => "required|in:S,N",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        //Data set
        $results= $this->worker->create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'mail' => $data['mail'],
            'sex' => $data['sex'],
            'active' => $data['active'],
            'office_id' => $data['office_id']
        ]);
        return response()->json($results,201);
        
    }
    /** Display the specified resource */
    public function show(Request $request,$id){
        //Put paremeters headers in the array request
        $request['id'] = $id;
        $request['office_id'] = $this->office_id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.workers,id",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        //Find Register whit office_id
        $exist = $this->worker->where ('id',$id)
                            ->where ('office_id',$data['office_id'])
                            ->exists();
        // Exist row;
        if($exist){
            // Query
            try{
                $results = $this->worker->findOrFail($id);
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
        $request['id'] = $id;
        $request['office_id'] = $this->office_id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.workers,id",
            'name'=> "required|max:60",
            'surname'=> 'required|max:60',
            'mail'   => "required|max:30",
            'sex'    => "required|in:H,M",
            'active'    => "required|in:S,N",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        //Find Register whit office_id
        $exist = $this->worker->where ('id',$id)
                            ->where ('office_id',$data['office_id'])
                            ->exists();    
        // Exist row;
        if($exist){
            // Query
            try{
                $row=$this->worker->findOrFail($id);
                $results= $row ->update([
                    'name' => $data['name'],
                    'surname' => $data['surname'],
                    'mail' => $data['mail'],
                    'sex' => $data['sex'],
                    'active' => $data['active'],
                    // 'office_id' => $data['office_id']
                ]);
                return response()->json($row,200);
            }
            catch(\Exception $e){return response()->json(['error'=>'Bad Request'],400,[]);}
        } 
        return response()->json(['error'=>'Not Content'],404,[]);

    }
    /** Remove the specified resource from storage*/
    public function destroy(Request $request,$id){
        //Put paremeters headers and get in the array request
        $request['id'] = $id;
        $request['office_id'] = $this->office_id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.workers,id",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        //Find Register whit office_id ando office_id
        $exist = $this->worker->where ('id',$id)
                            ->where ('office_id',$data['office_id'])
                            ->exists();
        // Exist row;   
        if($exist){
            //Query
            try{
                $results = $this->worker->findOrFail($id);
                $results->update(['active' => 'N']);
                return response()->json($results,200);
            }
            catch(\Exception $e){return response()->json(['error'=>'No Content'],406,[]);}
        } 
        return response()->json(['error'=>'Not Content'],404,[]);

    }
}
