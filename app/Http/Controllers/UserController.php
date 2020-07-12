<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
//Model
use App\User as User;
use App\OfficeUser as OfficeUser;
use Helpers;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user, OfficeUser $office_user, Request $request)
    {
        //Instance
        $this->user = $user;
        $this->office_user = $office_user;
        //database get year
        $route=$request->route();
        $this->year=$route[2]['year'];
        $this->database = is_array($route) ?  Helpers::name_database($this->year) : 0;
        //Choose database
        try{$this->user->setConnection($this->database);
        }catch(\Exception $e){}
        
        try{$this->office_user->setConnection($this->database);
        }catch(\Exception $e){}
        
    }
    /** Display a listing of the resource */
    public function index(){
        //$results = $user->find(1)->contacts;
        // $results = $user->find(6)->level;
        // $results = $user->find(4)->calls;
        //$results = $user->find(2)->events;
        // $results = $user->find(5)->documents;
        //Pivot Mostrar todas las officinas que administra la secretaria
        // $results = $user->find(3)->offices;
        //Query
        $results = $this->user
                    ->paginate(Helpers::number_paginate());
        //Response
        return response()->json($results,200); 

    }
    /** Store a newly created resource in storage*/
    public function store(Request $request){
        //Put paremeters in the array request
        $request['api_token']=Helpers::create_token();
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'name'=> "required|max:60|unique:$this->database.users,name",
            'password'=> 'required|max:100',
            'api_token'   => "required|size:60|unique:$this->database.users,api_token",
            'level_id'=> "required|integer|exists:$this->database.levels,id",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        //Data set
        $result_user= $this->user->create([
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'api_token' => $data['api_token'],
            'active' => 'S', // S o N
            'level_id' => $data['level_id']
        ]);
        // Id user
        if($result_user->id>0){
            $result_office_user= $this->office_user->create([
                'office_id' => $data['office_id'],
                'user_id' => $result_user->id,
            ]);
        }
        $result_user = Arr::add($result_user, 'office_id', $data['office_id']);
        $result_user = Arr::add($result_user, 'office_user_id', $result_office_user->id);
        return response()->json($result_user,200);
    }
    /** Destroy the api token */
    public function logout(Request $request){
        //Put paremeters headers and get in the array request
        $request['user-id'] = $request->header('user-id');
        $request['x-api-key'] =  $request->header('x-api-key');
         //Validate Data and Get dates request 
         $data= $this->validate($request,[
            'user-id' => "required|integer|exists:$this->database.users,id",
            'x-api-key'=> "required|exists:$this->database.users,api_token",
        ]);
        //Exist
        $exist = $this->user
                        ->where('id', $data['user-id'])        
                        ->where('api_token', $data['x-api-key'])
                        ->exists();
        if($exist){
            try{
                    $row = $this->user->findOrFail($data['user-id']);
                    $results= $row->update([
                        'api_token' => Helpers::create_token(),
                    ]);
                    return response()->json($results,200);
                }
                catch(\Exception $e){return response()->json(['error'=>'Bad Request'],400,[]);}
        }
        return response()->json(['error'=>'Not Content'],404,[]); 
    }
    /** Reset the api token */
    public function reset(Request $request){
        //Put paremeters headers and get in the array request
        $request['user-id'] = $request->header('user-id');
        $request['x-api-key'] =  $request->header('x-api-key');
         //Validate Data and Get dates request 
         $data= $this->validate($request,[
            'user-id' => "required|integer|exists:$this->database.users,id",
            'x-api-key'=> "required|exists:$this->database.users,api_token",
        ]);
        //Exist
        $exist = $this->user
                        ->where('id', $data['user-id'])        
                        ->where('api_token', $data['x-api-key'])
                        ->exists();
        if($exist){
            try{
                    $row = $this->user->findOrFail($data['user-id']);
                    $results= $row->update([
                        'api_token' => Helpers::create_token(),
                    ]);
                    return response()->json($row->api_token,200);
                }
                catch(\Exception $e){return response()->json(['error'=>'Bad Request'],400,[]);}
        }
        return response()->json(['error'=>'Not Content'],404,[]); 
    }

    /** Display the api token*/
    public function login(Request $request, OfficeUser $office_user){
         //Validate Data and Get dates request 
         $data= $this->validate($request,[
            'name'=> "required|max:60",
            'password'=> 'required|max:100',
            ]);
        //Data set
        try{
            $results = $this->user->where('name',$data['name'])
                            ->where('active','S')->first();
            $check = Hash::check($data['password'], $results->password);
            if ($results && $check ) {
                $office_list=$office_user->getOffice($this->year,$results->id);
                // The passwords match...
                $array_response=array(
                    'id'=>$results->id,
                    'user'=>$results->name, 
                    'api_token' => $results->api_token,
                    'level' => $results->level->name,
                    'level_id' => $results->level->id,
                    'office_id' => $office_list[0],
                    'office_list' => $office_list,
                ); 
                return response()->json($array_response,201);
            }else{
                // return response()->json(['check'=>$check],401);
                return response()->json(['error'=>'Unauthorized'],401);
            }
        }catch(\Exception $e){
        // }catch(ModelNotFoundException $e){
            // IF NOT HAVE A OFFICE
            return response()->json(['error'=>'No content'],406);
            //$e->getCode(); $e->getFile(); $e->getLine(); $e->getTraceAsString();
            //return $e->getMessage();
        }; 
    }
    /** Display the specified resource */
    public function show(Request $request,$id){
        //Put paremeters headers and get in the array request
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.users,id",
        ]);
        //Query
        try{
            $results = $this->user->findOrFail($id);
            //Response
            return response()->json($results,200);
        }
        catch(\Exception $e){return response()->json(['error'=>'Bad Request'],400,[]);}
    }
    /** Update the specified resource in storage*/
    public function update(Request $request, $id){
        //Put paremeters headers and get in the array request
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.users,id",
            'name'=> "required|max:60",
            'password'=> 'required|max:100',
            'active'    => "required|in:S,N",
            'level_id'=> "required|integer|exists:$this->database.levels,id",
            
        ]);
        //Query
        try{
            $row = $this->user->findOrFail($id);
            $results= $row ->update([
                'name' => $data['name'],
                'password' => Hash::make($data['password']),
                'active' => $data['active'],
                'level_id' => $data['level_id']
                
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
            'id' => "required|integer|exists:$this->database.users,id",
        ]);
        //Query
        try{
            $row = $this->user->findOrFail($id);
            $results= $row ->update(['active' => 'N']);
            return response()->json($results,200);
        }
        catch(\Exception $e){return response()->json(['error'=>'No Content'],406,[]);}
    
    }
}
