<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
//Model
use App\Example as Example;

class MailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    /** Display a listing of the resource */
    public function index(){}
    /** Store a newly created resource in storage*/
    public function store(Request $request){
       
        ini_set('max_execution_time', 180); //3 minutes
        $exitCode = Artisan::call('cache:clear');
  
   
        Mail::raw('emails.welcome', function ($message){
            $message->to(['laguilar1@ucol.mx']);
        });
        

    //    Mail::raw('Text to e-mail', function($message){
    //         $message->from('luxudux@gmail.com','Laravel');
    //         $message->to('laguilar1@ucol.mx');
    //     }); 
        

    }
    /** Display the specified resource */
    public function show(Example $example){}
    /** Update the specified resource in storage*/
    public function update(Request $request, Example $cexample){}
    /** Remove the specified resource from storage*/
    public function destroy(Example $example){}

    //
}
