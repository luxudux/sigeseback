<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//Model
use App\Delegation as Delegation;
use Helpers;

class DelegationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Delegation $delegation, Request $request)
    {
        //Instance
        $this->delegation=$delegation;
        //database get year
        $route=$request->route();
        $this->database = is_array($route) ?  Helpers::name_database($route[2]['year']) : 0;
        //Choose database
        try{$this->delegation->setConnection($this->database);
        }catch(\Exception $e){}
        //Get office key
        $this->office_id = $request->header('office-id');

    }
    public function index(Request $request){
        // Query
        $results = $this->delegation
                    ->paginate(Helpers::number_paginate());
        // Response
        return response()->json($results,200); 
    }
    /** Store a newly created resource in storage*/
    public function store(Request $request){
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'name'=> "required|max:60|unique:$this->database.delegations,name",
            'acronym'=> "required|max:12|unique:$this->database.delegations,acronym"
        ]);
        //Data set
        $results= $this->delegation->create([
            'name' => $data['name'],
            'acronym' => $data['acronym']
        ]);
        return response()->json($results,201); 
    }
    /** Display the specified resource */
    public function show(Request $request,$id){
        //Put paremeters headers in the array request
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.delegations,id",
        ]);
        //Query
        try{
            $results = $this->delegation->find($id);
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
            'id' => "required|integer|exists:$this->database.delegations,id",
            'name'=> 'required|max:60',
            'acronym'=> 'required|max:12',
        ]);
        //Query
        try{
            $row = $this->delegation->findOrFail($id);
            $results= $row ->update([
                'name' => $data['name'],
                'acronym' => $data['acronym']
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
            'id' => "required|integer|exists:$this->database.delegations,id",
        ]);
        //Query
        try{
            //Query
            $results = $this->delegation->findOrFail($id);
            $results->delete();
             //Response
            if($results){return response()->json($results,200);}
        }catch(\Exception $e){return response()->json(['error'=>'No Content'],406,[]);}
            
    }
}
