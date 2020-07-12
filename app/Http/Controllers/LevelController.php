<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//Model
use App\Level as Level;
use Helpers;

class LevelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Level $level, Request $request)
    {
        //Instance
        $this->level = $level;
        //database get year
        $route=$request->route();
        $this->database = is_array($route) ?  Helpers::name_database($route[2]['year']) : 0;
        //Choose database
        try{$this->level->setConnection($this->database);
        }catch(\Exception $e){}
    }
    public function index(){
        //Query
        $results = $this->level
                ->paginate(Helpers::number_paginate());
        //Response
        return response()->json($results,200); 
    }
    /** Store a newly created resource in storage*/
    public function store(Request $request){
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'name'=> "required|max:30|unique:$this->database.levels,name",
        ]);
        //Data set
        $results= $this->level->create([
           'name' => $data['name']
        ]);
       return response()->json($results,201); 
    }
    /** Display the specified resource */
    public function show(Request $request,$id){
        //Put paremeters headers in the array request
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.levels,id",
        ]);
        //Query
        try{
            $results = $this->level->findOrFail($id);
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
            'id' => "required|integer|exists:$this->database.levels,id",
            'name'=> "required|max:30|unique:$this->database.levels,name",
        ]);
        //Query
        try{
            $row = $this->level->findOrFail($id);
            $results= $row ->update([
                'name' => $data['name']
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
            'id' => "required|integer|exists:$this->database.levels,id",
        ]);
        try{
            //Query
            $results = $this->level->findOrFail($id);
            $results->delete();
            //Response
            if($results){return response()->json($results,200);}
        }catch(\Exception $e){return response()->json(['error'=>'No Content'],406,[]);}
           
    }
}
