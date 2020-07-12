<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//Model
use App\Preference as Preference;
use Helpers;

class PreferenceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Preference $preference, Request $request)
    {
        //Instance
        $this->preference = $preference;
        //database get year
        $route=$request->route();
        $this->database = is_array($route) ?  Helpers::name_database($route[2]['year']) : 0;
        //Choose database
        try{$this->preference->setConnection($this->database);
        }catch(\Exception $e){}
    }
    /** Display a listing of the resource */
    public function index(){
        //Query
        $results = $this->preference
                    ->paginate(Helpers::number_paginate());
        //Response
        return response()->json($results,200); 
    }
    /** Store a newly created resource in storage*/
    public function store(Request $request){
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'name'=> "required|max:30|unique:$this->database.preferences,name",
            'icon'=> "required|max:30|unique:$this->database.preferences,icon",
            'color_icon'=> 'required|max:30',
            'color_text'=> 'required|max:12',
            'color_back'=> 'required|max:12',
        ]);
        //Data set
        $results= $this->preference->create([
            'name' => $data['name'],
            'icon' => $data['icon'],
            'color_icon' => $data['color_icon'],
            'color_text' => $data['color_text'],
            'color_back' => $data['color_back']
        ]);
        return response()->json($results,201); 
    }
    /** Display the specified resource */
    public function show(Request $request,$id){
        //Put paremeters headers in the array request
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.preferences,id",
        ]);
        //Query
        try{
            $results = $this->preference->findOrFail($id);
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
            'id' => "required|integer|exists:$this->database.preferences,id",
            'name'=> "required|max:30",
            'icon'=> "required|max:30",
            'color_icon'=> 'required|max:30',
            'color_text'=> 'required|max:12',
            'color_back'=> 'required|max:12',
        ]);
        //Query
        try{
            $row = $this->preference->findOrFail($id);
            $results= $row ->update([
                'name' => $data['name'],
                'icon' => $data['icon'],
                'color_icon' => $data['color_icon'],
                'color_text' => $data['color_text'],
                'color_back' => $data['color_back']
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
            'id' => "required|integer|exists:$this->database.preferences,id",
        ]);
        //Query
        try{
            $results = $this->preference->findOrFail($id);
            $results->delete();
            //Response
            if($results){return response()->json($results,200);}
        }catch(\Exception $e){return response()->json(['error'=>'No Content'],406,[]);}
            
    }
}
