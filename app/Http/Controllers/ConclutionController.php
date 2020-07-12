<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//Model
use App\Conclution as Conclution;
use Helpers;

class ConclutionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Conclution $conclution, Request $request)
    {
        //Instance
        $this->conclution=$conclution;
        //database get year
        $route=$request->route();
        $this->database = is_array($route) ?  Helpers::name_database($route[2]['year']) : 0;
        //Choose database
        try{$this->conclution->setConnection($this->database);
        }catch(\Exception $e){}

    }
     /** Display a listing of the resource */
    public function index(){
        //Query
        $results = $this->conclution
                    ->paginate(Helpers::number_paginate());
        //Response
        return response()->json($results,200); 
    }
    /** Store a newly created resource in storage*/
    public function store(Request $request){
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'name'=> "required|max:30|unique:$this->database.conclutions,name",
            'icon'=> "required|max:30|unique:$this->database.conclutions,icon",
            'color_icon'=> 'required|max:30',
        ]);
        //Data set
        $results= $this->conclution->create([
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
            'id' => "required|integer|exists:$this->database.conclutions,id",
        ]);
        //Query
        try{
            $results = $this->conclution->findOrFail($id);
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
            'id' => "required|integer|exists:$this->database.conclutions,id",
            'name'=> "required|max:30",
            'icon'=> "required|max:30",
            'color_icon'=> 'required|max:30',
        ]);
        //Query
        try{
            $row = $this->conclution->findOrFail($id);
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
            'id' => "required|integer|exists:$this->database.conclutions,id",
        ]);
        try{
            //Query
            $results = $this->conclution->findOrFail($id);
            $results->delete();
             //Response
            if($results){return response()->json($results,200);}
        }catch(\Exception $e){return response()->json(['error'=>'No Content'],406,[]);}

    }
}
