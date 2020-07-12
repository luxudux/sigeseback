<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//Model
use App\Example as Example;

class ExampleController extends Controller
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
    public function store(Request $request){}
    /** Display the specified resource */
    public function show(Example $example){}
    /** Update the specified resource in storage*/
    public function update(Request $request, Example $cexample){}
    /** Remove the specified resource from storage*/
    public function destroy(Example $example){}

    //
}
