<?php

namespace App\Helpers;

/**
 * CacheHelper
 *
 * @author Virendra Jadeja <virendrajadeja84@gmail.com>
 */
class CacheHelper {

    public static function getKey($classPath, $method, $args = null) {
        $cacheVar = NULL;
        $keywords = explode("\\", $classPath);
        $class = strtolower(str_replace("Controller", "", end($keywords)));
        if ($class):
            $cacheVar = $class;
        endif;
        if ($method):
            $cacheVar .= "_" . $method;
        endif;

        if ($args):
            if (is_array($args)):
                foreach ($args as $k => $v):
                    $cacheVar .= "_" . $k . "_" . $v;
                endforeach;
            else:
                $cacheVar .= "_" . $args;
            endif;
        endif;

        return $cacheVar;
    }

}
