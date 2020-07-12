<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//Model
use App\Event as Event;
use Helpers;

class EventController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Event $event, Request $request)
    {
        //Instance
        $this->event = $event;
        //database get year
        $route=$request->route();
        $this->database = is_array($route) ?  Helpers::name_database($route[2]['year']) : 0;
        //Choose database
        try{$this->event->setConnection($this->database);
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
        $table_view="view_events";
        //Find Register whit office_id
        // $exist = $this->event
        //                 ->where ('office_id',$data['office_id'])
        //                 ->exists();
        // // Exist row;
        // if($exist){
            try{
                //Query
                $results =$this->conection 
                    ->table($table_view)
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
            'title'=> "required|max:50",
            'description'=> "required|max:200",
            'start'=> 'required|date_format:Y-m-d H:i:s',
            'end'=> 'required|date_format:Y-m-d H:i:s',
            'preference_id'=> "required|integer|exists:$this->database.preferences,id",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
            'user_id'=> "required|integer|exists:$this->database.users,id",
        ]);
        try{
            //Data set
            $results= $this->event->create([
                'title' => $data['title'],
                'description' => $data['description'],
                'start' => $data['start'],
                'end' => $data['end'],
                'preference_id' => $data['preference_id'],
                'office_id' => $data['office_id'],
                'user_id' => $data['user_id']
            ]);
            return response()->json($results,201);
        }catch(\Exception $e){return response()->json(['error'=>'Conflict'],409,[]);} 
    }
    /** Display the specified resource */
    public function show(Request $request,$id){
        //Put paremeters headers in the array request
        $request['office_id'] = $this->office_id;
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.events,id",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        //Find Register whit office_id
        $exist = $this->event->where ('id',$id)
                        ->where ('office_id',$data['office_id'])
                        ->exists();
        // Exist row;
        if($exist){
            // Query
            try{
                $results = $this->event->findOrFail($id);
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
            'id' => "required|integer|exists:$this->database.events,id",
            'title'=> "required|max:50",
            'description'=> "required|max:200",
            'start'=> 'required|date_format:Y-m-d H:i:s',
            'end'=> 'required|date_format:Y-m-d H:i:s',
            'preference_id'=> "required|integer|exists:$this->database.preferences,id",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
            'user_id'=> "required|integer|exists:$this->database.users,id",
        ]);
        //Find Register whit office_id
        $exist = $this->event->where ('id',$id)
                        ->where ('office_id',$data['office_id'])
                        ->exists();
        // Exist row;
        if($exist){
            // Query
            try{
                $row=$this->event->findOrFail($id);
                $results= $row ->update([
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'start' => $data['start'],
                    'end' => $data['end'],
                    'preference_id' => $data['preference_id'],
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
            'id' => "required|integer|exists:$this->database.events,id",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        //Find Register whit office_id
        $exist = $this->event->where ('id',$id)
                    ->where ('office_id',$this->office_id)
                    ->exists();
        // Exist row;
        if($exist){
            try{
                //Query
                $results = $this->event->findOrFail($id);
                $results->delete();
                //Response
                if($results){return response()->json($results,200);}
            }catch(\Exception $e){return response()->json(['error'=>'No Content'],406,[]);}
        }
        return response()->json(['error'=>'Not Content'],404,[]); 
    }
}
