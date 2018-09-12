<?php

namespace LollyPlus;

use Lolly\Config\Config;

class Lolly{

    //运行LollyPlus项目
    public static function Run(){
        $config = Config::ReadConf("site");
        if(! is_null($config)){

            //开启或关闭Debug
            if ($config["Site_DEBUG"]) {
                error_reporting(E_ALL);
                ini_set('display_errors','On');
            } else {
                error_reporting(E_ALL);
                ini_set('display_errors','Off');
                ini_set('log_errors', 'On');
            }

            //解析URL
            $url = $_SERVER["REQUEST_URI"];
            $pos = strpos($url,'?');
            $url = $pos === false ? $url : substr($url, 0, $pos);
            $url = trim($url,'/');

            $urlList = explode('/',$url);
            var_dump($urlList);
        }
    }
}
