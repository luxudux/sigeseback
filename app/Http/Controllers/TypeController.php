<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//Model
use App\Type as Type;
use Helpers;

class TypeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Type $type, Request $request)
    {
        //Instance
        $this->type=$type;
        //database get year
        $route=$request->route();
        $this->database = is_array($route) ?  Helpers::name_database($route[2]['year']) : 0;
        //Choose database
        try{$this->type->setConnection($this->database);
        }catch(\Exception $e){}
        //Get office key
        $this->office_id = $request->header('office-id');

    }
    public function index(Request $request){
        // Query
        $results = $this->type
                    ->paginate(Helpers::number_paginate());
        // Response
        return response()->json($results,200); 
    }
    /** Store a newly created resource in storage*/
    public function store(Request $request){
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'name'=> "required|max:60|unique:$this->database.types,name",
            'code'=> "required|max:12|unique:$this->database.types,code"
        ]);
        //Data set
        $results= $this->type->create([
            'name' => $data['name'],
            'code' => $data['code']
        ]);
        return response()->json($results,201); 
    }
    /** Display the specified resource */
    public function show(Request $request,$id){
        //Put paremeters headers in the array request
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.types,id",
        ]);
        //Query
        try{
            $results = $this->type->find($id);
            //Response
            return response()->json($results,200);
        }
        catch(\Exception $e){return response()->json(['error'=>'Bad Request'],400,[]);} 

    }
    /** Update the specified resource in storage*/
    public function update(Request $request, $id){
        //Put paremeters headers in the array request
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.types,id",
            'name'=> 'required|max:60',
            'code'=> 'required|max:12',
        ]);
        //Query
        try{
            $row = $this->type->findOrFail($id);
            $results= $row ->update([
                'name' => $data['name'],
                'code' => $data['code']
            ]);
            return response()->json($row,200);
        }
        catch(\Exception $e){return response()->json(['error'=>'Bad Request'],400,[]);} 
       
         
    }
    /** Remove the specified resource from storage*/
    public function destroy(Request $request,$id){
        //Put paremeters headers in the array request
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.types,id",
        ]);
        //Query
        try{
            //Query
            $results = $this->type->findOrFail($id);
            $results->delete();
             //Response
            if($results){return response()->json($results,200);}
        }catch(\Exception $e){return response()->json(['error'=>'No Content'],406,[]);}
            
    }
}
