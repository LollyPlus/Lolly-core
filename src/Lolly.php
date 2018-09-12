<?php

namespace Lolly;

use Lolly\Tools\Config;

class Lolly{

    private $route = [];
    private $num = [];

    //运行LollyPlus项目
    public function Run(){
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
            $pos = strpos($path,'?');
            $path = $pos === false ? $path : substr($path, 0, $pos);
            $path = trim($path,'/');
            $pathList = explode('/',$path);

            //获取更多数据
            $param = $urlList;
            array_shift($param);
            if(substr($_SERVER["REQUEST_URI"],-1) == '/' && isset($urlList[0])){
                array_push($param,'');
            }

            //处理访问的URL
            if(! sizeof($urlList) < sizeof($pathList)) {
                for ($i = 0; $i < sizeof($pathList); $i++) {
                    if ($pathList[$i] != $urlList[$i]) {
                        $this->_404();
                    }
                    array_shift($urlList);
                }
            }else{
                $this->_404();
            }

            //根据URL获取函数返回值
            $route = $urlList[0];

            if(array_key_exists($route,$this->route)){
                $func = $this->route[$route];
                if(is_string($func)){
                    @call_user_func($func,$param);
                }elseif(is_object($func)){
                    @$func($param);
                }else{
                    $this->_404();
                }
            }
        }
    }

    public function Route($path,$func,$num=0){
        $this->route[$path] = $func;
        $this->num[$path] = $num;
    }

    private function _404(){
        exit("404 Not Find");
    }
}
