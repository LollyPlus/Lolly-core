<?php

namespace Lolly\Core\View;

class Error{
    public static function Render_Error($code=404,$suffix="html"){
        $path = Lolly . '/app/view/error/' . (string)$code . '.' . $suffix;
        if(is_file($path)){
            exit(@file_get_contents($path));
        }
    }
}