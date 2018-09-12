<?php

namespace Lolly\Config;

class Config{
    public static function ReadConf($name){
        if(is_file(LollyPlus . "/config/" . $name . ".php")){
            return require LollyPlus . "/config/" . $name . ".php";
        }else{
            return null;
        }
    }
}