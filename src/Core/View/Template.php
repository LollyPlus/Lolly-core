<?php

namespace Lolly\Core\View;

use Lolly\Template\Wetpl\Wetpl;
use Lolly\Tools\Config;

class Template{
    public static function Rander($file,$var){
        $config = Config::ReadConf('template');
        if(strtolower($config['Tpl_Type']) == "wetpl"){
            $left = $config['Left_Delimit'];
            $right = $config['Right_Delimit'];
            $location = $config['Domain_Location'];

            $var[$location] = _PUBLIC_;

            return Wetpl::render($file,$var,$left,$right);
        }
        return '';
    }
}