<?php

namespace Lolly;

use Lolly\Core\View\Error;
use Lolly\Tools\Config;

class Lolly{

    private $route = [];
    private $num = [];

    private $static = [];

    //运行Lolly项目
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

            //加载Route配置文件路由
            $routes = Config::ReadConf("route");
            foreach($routes as $key => $val){
                if(is_string($val)){
                    $this->route[$key] = $val;
                    $this->num[$key] = 0;
                }elseif(is_array($val)){
                    if(isset($val['func'],$val['num'])){
                        $this->route[$key] = $val['func'];
                        $this->num[$key] = $val['num'];
                    }
                }
            }

            //加载Static静态路径
            $statics = $config['Static_Path'];
            foreach($statics as $key => $val){
                $this->static[$key] = $val;
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
            $urls = $urlList;

            //处理访问的URL
            if(sizeof($urls) >= sizeof($pathList)) {
                for ($i = 0; $i < sizeof($pathList); $i++) {
                    if ($pathList[$i] != $urls[$i]) {
                        $this->_404();
                    }
                    array_shift($urlList);
                    array_shift($param);
                }
            }else{
                $this->_404();
            }

            //处理特殊情况
            array_shift($param);
            if(substr($_SERVER["REQUEST_URI"],-1) == '/' && isset($urlList[0])){
                array_push($param,'');
            }

            //根据URL获取函数返回值
            if(sizeof($urlList) > 0){
                $route = $urlList[0];
            }else{
                $route = $config['Site_Index'];
            }

            if(array_key_exists($route,$this->route)){
                $func = $this->route[$route];
                if(is_string($func)){
                    @exit(call_user_func($func,$param));
                }elseif(is_object($func)){
                    @exit($func($param));
                }else{
                    $this->_404();
                }
            }elseif(array_key_exists($route,$this->static)){
                $dir = Lolly . '/app/view/public' . $this->static[$route];
                if(is_file($dir .  implode('/',$param))){
                    exit(@file_get_contents($dir .  implode('/',$param)));
                }
            }else{
                $this->_404();
            }

        }
    }

    //加载单个路由
    public function Route($path,$func,$num=0){
        $this->route[$path] = $func;
        $this->num[$path] = $num;
    }

    //增加静态路径
    public function StaticPath($name,$path){
        $this->static[$name] = $path;
    }

    //404页面显示
    private function _404(){
        Error::Render_Error(404);
    }
}