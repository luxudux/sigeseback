<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//Model
use App\Town as Town;
use Helpers;

class TownController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Town $town, Request $request)
    {
        //Instance
        $this->town=$town;
        //database get year
        $route=$request->route();
        $this->database = is_array($route) ?  Helpers::name_database($route[2]['year']) : 0;
        //Choose database
        try{$this->town->setConnection($this->database);
        }catch(\Exception $e){}
        //Get office key
        $this->office_id = $request->header('office-id');

    }
    public function index(Request $request){
        // Query
        $results = $this->town
                    ->paginate(Helpers::number_paginate());
        // Response
        return response()->json($results,200); 
    }
    /** Store a newly created resource in storage*/
    public function store(Request $request){
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'name'=> "required|max:60|unique:$this->database.towns,name",
            'stranger'=> "required|in:S,N"
        ]);
        //Data set
        $results= $this->town->create([
            'name' => $data['name'],
            'stranger' => $data['stranger']
        ]);
        return response()->json($results,201); 
    }
    /** Display the specified resource */
    public function show(Request $request,$id){
        //Put paremeters headers in the array request
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.towns,id",
        ]);
        //Query
        try{
            $results = $this->town->find($id);
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
            'id' => "required|integer|exists:$this->database.towns,id",
            'name'=> 'required|max:60',
            'stranger'=> 'required|in:S,N',
        ]);
        //Query
        try{
            $row = $this->town->findOrFail($id);
            $results= $row ->update([
                'name' => $data['name'],
                'stranger' => $data['stranger']
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
            'id' => "required|integer|exists:$this->database.towns,id",
        ]);
        //Query
        try{
            //Query
            $results = $this->town->findOrFail($id);
            $results->delete();
             //Response
            if($results){return response()->json($results,200);}
        }catch(\Exception $e){return response()->json(['error'=>'No Content'],406,[]);}
            
    }
}
