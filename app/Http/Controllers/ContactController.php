<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//Model
use App\Contact as Contact;
use Helpers;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Contact $contact, Request $request)
    {
        //Instance
        $this->contact=$contact;
        //database get year
        $route=$request->route();
        $this->database = is_array($route) ?  Helpers::name_database($route[2]['year']) : 0;
        //Choose database
        try{$this->contact->setConnection($this->database);
        }catch(\Exception $e){}
        //Get office id, user key
        $this->office_id = $request->header('office-id');
        $this->user_id = $request->header('user-id');
    }
    public function index(Request $request){
        //Put paremeters headers in the array request
        $request['office_id'] = $this->office_id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        //Find Register whit office_id 
        $exist = $this->contact
                            ->where ('office_id',$data['office_id'])
                            ->exists();   
        // Exist row;
        if($exist){
            try{
                //Query
                $results = $this->contact
                ->where('office_id',$this->office_id)
                ->paginate(Helpers::number_paginate());
                //Response
                return response()->json($results,200); 
            }
            catch(\Exception $e){return response()->json(['error'=>'No Content'],406,[]);}
        }
        return response()->json(['error'=>'Not Content'],404,[]);
    }
    /** Store a newly created resource in storage*/
    public function store(Request $request, $year){
        //Put paremeters headers in the array request
        $request['office_id'] = $this->office_id;
        $request['user_id'] = $this->user_id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'name'=> "required|max:60",
            'surname'=> 'required|max:60',
            'town_id'   => "required|integer|exists:$this->database.towns,id",
            'phone_p'=> "nullable|max:15",
            'phone_s'=> "nullable|max:15",
            'sex'    => "required|in:H,M",
            'mail'   => "nullable|max:30|email",
            'institution'=> 'nullable|max:60',
            'office_id'=> "required|integer|exists:$this->database.offices,id",
            'user_id'=> "required|integer|exists:$this->database.users,id",
        ]);
        //Data set
        $results= $this->contact->create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'town_id' => $data['town_id'],
            'phone_p' => $data['phone_p'],
            'phone_s' => $data['phone_s'],
            'sex' => $data['sex'],
            'mail' => $data['mail'],
            'institution' => $data['institution'],
            'office_id' => $data['office_id'],
            'user_id' => $data['user_id'],
        ]);
        return response()->json($results,201);
    }
    /** Display the specified resource */
    public function show(Request $request,$id){
        //Put paremeters headers in the array request
        $request['office_id'] = $this->office_id;
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.contacts,id",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        //Find Register whit office_id 
        $exist = $this->contact->where ('id',$id)
                            ->where ('office_id',$data['office_id'])
                            ->exists();   
        // Exist row;
        if($exist){
            // Query
            try{
                $results = $this->contact->findOrFail($id);
                //Response
                return response()->json($results,200);
            }
            catch(\Exception $e){return response()->json(['error'=>'No Content'],406,[]);}
        }
        return response()->json(['error'=>'Not Content'],404,[]);
        
    }
    /** Update the specified resource in storage*/
    public function update(Request $request, $id){
        //Put paremeters headers in the array request
        $request['office_id'] = $this->office_id;
        $request['user_id'] = $this->user_id;
        $request['id'] = $id;
        //Validate Data and Get dates request 
        $data= $this->validate($request,[
            'id' => "required|integer|exists:$this->database.contacts,id",
            'name'=> "required|max:60",
            'surname'=> 'required|max:60',
            'town_id'   => "required|integer|exists:$this->database.towns,id",
            'phone_p'=> "nullable|max:15",
            'phone_s'=> "nullable|max:15",
            'sex'    => "required|in:H,M",
            'mail'   => "nullable|max:30|email",
            'institution'=> 'nullable|max:60',
            'office_id'=> "required|integer|exists:$this->database.offices,id",
            'user_id'=> "required|integer|exists:$this->database.users,id",
        ]);
        //Find Register whit office_id ando user_id
        $exist = $this->contact->where ('id',$id)
                            ->where ('office_id',$data['office_id'])
                            ->where ('user_id',$data['user_id'])
                            ->exists();     
        // Exist row;
        if($exist){
           // Query
            try{
                $row=$this->contact->findOrFail($id);
                $results= $row ->update([
                    'name' => $data['name'],
                    'surname' => $data['surname'],
                    'town_id' => $data['town_id'],
                    'phone_p' => $data['phone_p'],
                    'phone_s' => $data['phone_s'],
                    'sex' => $data['sex'],
                    'mail' => $data['mail'],
                    'institution' => $data['institution'],
                    'office_id' => $data['office_id'],
                    'user_id' => $data['user_id'],
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
            'id' => "required|integer|exists:$this->database.contacts,id",
            'office_id'=> "required|integer|exists:$this->database.offices,id",
        ]);
        //Find Register whit office_id
        $exist = $this->contact->where ('id',$id)
                    ->where ('office_id',$this->office_id)
                    ->exists();
        // Exist row;
        if($exist){
            try{
                //Query
                $results = $this->contact->findOrFail($id);
                $results->delete();
                //Response
                if($results){return response()->json($results,200);}
            }catch(\Exception $e){return response()->json(['error'=>'No Content'],406,[]);}
        }
        return response()->json(['error'=>'Not Content'],404,[]); 
          
    }
}
