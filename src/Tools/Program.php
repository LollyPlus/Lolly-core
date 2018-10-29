<?php

namespace Lolly\Tools;

class Program{
    public static function import($name){
        if(is_file(Lolly . "/app/program/" . $name . ".php")){
            require Lolly . "/app/program/" . $name . ".php";
            return true;
        }else{
            return false;
        }
    }
}