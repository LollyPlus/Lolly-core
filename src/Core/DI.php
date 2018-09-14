<?php

//依赖注入代码

namespace Lolly\Core;


use Lolly\Cache\FileCache;
use Lolly\Core\View\Template;
use Lolly\Model\DataBase;

class DI{

    //文件缓存
    public static function FileCache($group=null){
        return new FileCache($group);
    }

    //模板引擎
    public static function Rander_tpl($file,$var = []){
        return Template::Rander($file,$var);
    }

    //Medoo连接
    public static function Medoo($type='medoo'){
        return DataBase::Medoo();
    }
}