<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//Model
use App\State as State;
use Helpers;

class StateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(State $state, Request $request)
    {
        //Instance
        $this->state=$state;
        //database get year
        $route=$request->route();
        $this->database = is_array($route) ?  Helpers::name_database($route[2]['year']) : 0;
        //Choose database
        try{$this->state->setConnection($this->database);
        }catch(\Exception $e){}
    }
    /** Display a listing of the resource */
    public function index(){
        //Query
        $results = $this->state
                    ->paginate(Helpers::number_paginate());
        //Response
        return response()->json($results,200); 
    }
    /** Store a newly created resource in storage*/
    public function store(Request $request){
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'name'=> "required|max:60|unique:$this->database.states,name",
            'icon'=> 'required|max:60',
            'color_icon'=> 'required|max:30',
        ]);
        //Data set
        $results= $this->state->create([
            'name' => $data['name'],
            'icon' => $data['icon'],
            'color_icon' => $data['color_icon']
        ]);
        return response()->json($results,201);
    }
    /** Display the specified resource */
    public function show(Request $request,$id){
        //Put paremeters headers in the array request
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.states,id",
        ]);
        //Query
        try{
            $results = $this->state->findOrFail($id);
            //Response
            return response()->json($results,200);
        }
        catch(\Exception $e){return response()->json(['error'=>'Bad Request'],400,[]);}
    }
    /** Update the specified resource in storage*/
    public function update(Request $request,$id){
        //Put paremeters headers in the array request
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.states,id",
            'name'=> 'required|max:60',
            'icon'=> 'required|max:60',
            'color_icon'=> 'required|max:30',
        ]);
        //Query
        try{
            $row = $this->state->findOrFail($id);
            $results= $row ->update([
                'name' => $data['name'],
                'icon' => $data['icon'],
                'color_icon' => $data['color_icon']
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
            'id' => "required|integer|exists:$this->database.states,id",
        ]);
        //Query
        try{
            $results = $this->state->findOrFail($id);
            $results->delete();
            //Response
            if($results){return response()->json($results,200);}
        }catch(\Exception $e){return response()->json(['error'=>'No Content'],406,[]);}
            
    }
}
