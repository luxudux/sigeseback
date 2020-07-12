<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//Model
use App\Office as Office;
use Helpers;

class OfficeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Office $office, Request $request)
    {
        //Instance
        $this->office = $office;
        //database get year
        $route=$request->route();
        $this->database = is_array($route) ?  Helpers::name_database($route[2]['year']) : 0;
        //Choose database
        try{$this->office->setConnection($this->database);
        }catch(\Exception $e){}
    }
    /** Display a listing of the resource */
    public function index(){
        #Filtra segùn el id
        // $results = $this->office->find(4);
        #Muestra a que delegaciòn pertenece segun el id del centro de trabajo
        // $results = $this->office->find(4)->delegation;
        # Filtro Where, mostrando el primer registro
        // $results=$this->office->where('delegation_id','3')->first();
        # Filtro Where, mostrando todos los registros
        // $results=$this->office->where('delegation_id','3')->get();

        # Muestra todos los contactos segun del id de office
        // $results=$this->office->find(3)->contacts;
        # Muestra todas las llamadas que ha tenido esa officina
        // $results = $this->office->find(5)->calls;

        #Muestra todos los trabajadores segun id de office
        // $results = $this->office->find(6)->workers;
        # Muestra todos los eventos que tiene un centro de trabajo
        //$results = $this->office->find(2)->events;
        # Muestra todos los documentos que hizo el centro de trabajo
        // $results = $this->office->find(1)->documents;
        # Pivot: Muestra todas los usuarios que administran la oficina
        // $results = $this->office->find(3)->users;
        # Pivot: Muestra todos los documentos recividos por id de oficina
        // $results = $this->office->find(6)->doc_receivers;
        //Query
        $results = $this->office
                ->paginate(Helpers::number_paginate());
        //Response
        return response()->json($results,200);
        
        
    }
    /** Store a newly created resource in storage*/
    public function store(Request $request){
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'name'=> "required|max:80|unique:$this->database.offices,name",
            'acronym'=> 'required|max:12',
            'code'=> "required|max:10|unique:$this->database.offices,code",
            'mail'=> "required|max:30|email|unique:$this->database.offices,mail",
            'delegation_id'=> "required|integer|exists:$this->database.delegations,id",
        ]);
        //Data set
        $results= $this->office->create([
            'name' => $data['name'],
            'acronym' => $data['acronym'],
            'code' => $data['code'],
            'mail' => $data['mail'],
            'delegation_id' => $data['delegation_id']
        ]);
        return response()->json($results,200);
    }
    /** Display the specified resource */
    public function show(Request $request,$id){
        //Put paremeters headers in the array request
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.offices,id",
        ]);
        //Query
        try{
            $results = $this->office->findOrFail($id);
            //Response
            return response()->json($results,201);
        }
        catch(\Exception $e){return response()->json(['error'=>'Bad Request'],400,[]);}
        
    }
    /** Update the specified resource in storage*/
    public function update(Request $request, $id){
        //Put paremeters headers in the array request
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.offices,id",
            'name'=> "required|max:80",
            'acronym'=> 'required|max:12',
            'code'=> "max:10",
            'mail'=> "required|max:30",
            'delegation_id'=> "required|integer|exists:$this->database.delegations,id",
        ]);
        //Query
        try{
            $row = $this->office->findOrFail($id);
            $results= $row->update([
                'name' => $data['name'],
                'acronym' => $data['acronym'],
                'code' => $data['code'],
                'mail' => $data['mail'],
                'delegation_id' => $data['delegation_id']
            ]);
            return response()->json($row,200);
        }
        catch(\Exception $e){return response()->json(['error'=>'Bad Request'],400,[]);}
    }
    /** Remove the specified resource from storage*/
    public function destroy(Request $request,$id){
        //Put paremeters headers and get in the array request
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.offices,id",
        ]);
        try{
            //Query
            $results = $this->office->findOrFail($id);
            $results->delete();
            //Response
            if($results){return response()->json($results,200);}
        }catch(\Exception $e){return response()->json(['error'=>'No Content'],406,[]);}
    }
}
