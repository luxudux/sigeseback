<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//Model
use App\Call as Call;
use Helpers;

class CallController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Call $call, Request $request){
        //Instance
        $this->call=$call;
        //Database get year
        $route=$request->route();
        $this->database = is_array($route) ?  Helpers::name_database($route[2]['year']) : 0;
        //Choose database
        try{$this->call->setConnection($this->database);
        }catch(\Exception $e){}
        //Get office id, user key
        $this->office_id = $request->header('office-id');
        $this->user_id = $request->header('user-id');
        //Conection to database view_table
        $this->conection=DB::connection($this->database);
    }
    /** Display a listing of the resource */
    public function index(Request $request){
        //Put paremeters headers in the array request
        $request['office_id'] = $this->office_id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        $table_view="view_calls_received";
        //Find Register whit office_id and user_id
        // $exist = $this->call
        //             ->where ('office_id',$data['office_id'])
        //             ->exists(); 
        // if($exist){
            try{
                //Query
                $results =$this->conection 
                    ->table($table_view)
                    ->where ('office_id',$data['office_id'])
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
        $request['user_id'] = $this->user_id;
        $request['office_id'] = $this->office_id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'note'=> "required|max:200",
            'day'=> 'required|date_format:Y-m-d H:i:s',
            'contact_id'=> "required|integer|exists:$this->database.contacts,id",
            'user_id'=> "required|integer|exists:$this->database.users,id",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        //Data set
        if($this->office_id && $this->user_id){
            $results= $this->call->create([
                'note' => $data['note'],
                'day' => $data['day'],
                'contact_id' => $data['contact_id'],
                'user_id' => $data['user_id'],
                'office_id' => $data['office_id']
            ]);
            return response()->json($results,201);
        }
        return response()->json(['error'=>'Bad Request'],400,[]);
    }
    /** Display the specified resource */
    public function show(Request $request,$id){
        //Put paremeters headers in the array request
        $request['office_id'] = $this->office_id;
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.calls,id",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        //Find Register whit office_id and user_id
        $exist = $this->call->where ('id',$id)
                    ->where ('office_id',$data['office_id'])
                    ->exists(); 
        // Exist row;
        if($exist){
            // Query
            try{
                $results = $this->call->findOrFail($id);
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
        $request['user_id'] = $this->user_id;
        $request['office_id'] = $this->office_id;
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.calls,id",
            'note'=> "required|max:200",
            'day'=> 'required|date_format:Y-m-d H:i:s',
            'contact_id'=> "required|integer|exists:$this->database.contacts,id",
            'user_id'=> "required|integer|exists:$this->database.users,id",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        //Find Register whit office_id and user_id
        $exist = $this->call->where ('id',$id)
                    ->where ('office_id',$data['office_id'])
                    ->where ('user_id',$data['user_id'])
                    ->exists();        
        // Exist row;
        if($exist){
            // Query
            try{
                $row=$this->call->findOrFail($id);
                $results= $row ->update([
                    'note' => $data['note'],
                    'day' => $data['day'],
                    'contact_id' => $data['contact_id'],
                ]);
                return response()->json($row,200);
            }
            catch(\Exception $e){return response()->json(['error'=>'Bad Request'],400,[]);}
        } 
        return response()->json(['error'=>'Not Content'],404,[]);

    }
    /** Remove the specified resource from storage*/
    public function destroy(Request $request, $id){
        //Put paremeters headers and get in the array request
        $request['id'] = $id;
        $request['office_id'] = $this->office_id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.calls,id",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        //Find Register whit office_id
        $exist = $this->call->where ('id',$id)
                            ->where ('office_id',$this->office_id)
                            ->exists();
        // Exist row;
        if($exist){
            try{
                //Query
                $results = $this->call->findOrFail($id);
                $results->delete();
                 //Response
                if($results){return response()->json($results,200);}
            }catch(\Exception $e){return response()->json(['error'=>'No Content'],406,[]);}
        } 
        return response()->json(['error'=>'Not Content'],404,[]);  
    }
}
