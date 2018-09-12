<?php

namespace Lolly;

use Lolly\Tools\Config;

class Lolly{

    //运行LollyPlus项目
    public static function Run(){
        $config = Config::ReadConf("site");
        if(! is_null($config)){

            //开启或关闭Debug
            if ($config["Site_Debug"]) {
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

            //解析访问地址
            $path = $config['Local_Path'];
            $pos = strpos($url,'?');
            $url = $pos === false ? $url : substr($url, 0, $pos);
            $url = trim($url,'/');
            $pathList = explode('/',$url);

            for($i = 0;$i < sizeof($pathList);$i++){
                if($pathList[$i] != $urlList[$i]){
                    exit("404 Not Find");
                }
            }
            echo "hahah";
        }
    }
}
