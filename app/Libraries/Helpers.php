<?php 

class Helpers
{
    //Devuelve el tipo de conexión segun la base de datos
    public static function name_database($year)
    {
        if($year>=2019){
            $conexion= $year ? 'mysql'.$year : 'mysql_default';
            return $conexion;
        }
        //Database default
        return 'mysql2019';
    }   
    //Number of pages on index
    public static function number_paginate(){
        // return 15;
        return 150; // All
    }
    //CreateToken
    public static function create_token(){
        return str_random(60);
    }
    //Archives directory
    public static function directory_file($year){
        if($year){
            return "doc/".$year;
        }else{
            return "default/";
        }
    }

}