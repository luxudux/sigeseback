<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//Model
use App\OfficeUser as OfficeUser;
use App\ViewOfficeUsers as ViewOfficeUsers;
use Helpers;

class OfficeUserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        OfficeUser $office_user, 
        ViewOfficeUsers $view_office_users,
        Request $request)
    {
        //Instance
        $this->office_user = $office_user;
        $this->view_office_users = $view_office_users;
        //database get year
        $route=$request->route();
        $this->database = is_array($route) ?  Helpers::name_database($route[2]['year']) : 0;
        //Choose database
        try{$this->office_user->setConnection($this->database);
        }catch(\Exception $e){}
        try{$this->view_office_users->setConnection($this->database);
        }catch(\Exception $e){}
        //Get office id, user key
        $this->office_id = $request->header('office-id');
        $this->user_id = $request->header('user-id');
    }
    /** Display a listing of the resource */
    public function index(){
            //Query
            // $results = DB::connection($this->database)
            //             // ->table('view_office_users')
            //             ->table('office_users')
            //             ->paginate(Helpers::number_paginate());
                  
            $results = $this->view_office_users
                    ->paginate(Helpers::number_paginate());
            //Response
            return response()->json($results,200);
    }
    /** Store a newly created resource in storage*/
    public function store(Request $request){
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'office_id'=> "required|integer|exists:$this->database.offices,id",
            'user_id'=> "required|integer|exists:$this->database.users,id",
        ]);
        try{
            //Data set
            $results= $this->office_user->create([
            'office_id' => $data['office_id'],
            'user_id' => $data['user_id']
            ]);
            return response()->json($results,200);

        }catch(\Exception $e){return response()->json(['error'=>'Conflict'],409,[]);} 
        
    }
    /** Display the specified resource */
    public function show(Request $request,$id){
        //Put paremeters headers in the array request
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.office_users,id",
        ]);
        //Query
        try{
            //Query
            $results = $this->office_user->findOrFail($id);
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
            'id' => "required|integer|exists:$this->database.office_users,id",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
            'user_id'=> "required|integer|exists:$this->database.users,id",
        ]);
        //Query
        try{
           $row = $this->office_user->findOrFail($id);
            $results= $row ->update([
               'office_id' => $data['office_id'],
               'user_id' => $data['user_id']
            ]);
            return response()->json($row,201);
        }
        catch(\Exception $e){return response()->json(['error'=>'Bad Request'],400,[]);}
         
    }
    /** Remove the specified resource from storage*/
    public function destroy(Request $request,$id){
            //Put paremeters headers in the array request
            $request['id'] = $id;
            //Validate Data and Get dates request 
            $data= $this->validate($request,[
                'id' => "required|integer|exists:$this->database.office_users,id",
            ]);
        //Query
        try{
            $results = $this->office_user->findOrFail($id);
            $results->delete();
            //Response
            if($results){return response()->json($results,200);}
        }catch(\Exception $e){return response()->json(['error'=>'No Content'],406,[]);}

    }
}
