<?php
    function strip_zeros($str = "")
    {
        $remove_zeros = str_replace('*0', '', $str);
        $clean = str_replace('*', '', $remove_zeros);
        return $clean;
    }
    
    function redirect_to($location = null)
    {
        if ($location != null) {
            header("Location: {$location}");
            exit;
        }
    }
    
    function opmsg($msg="", $status="")
    {
        if (!empty($msg)) {
            $new_msg = '<div class="alert alert-'. $status .'" role="alert"><i class="fa fa-info-circle"></i> '. $msg .'</div>';
            return $new_msg;
        }
    }
    
    function getPublicVars($obj)
    {
        return get_object_vars($obj);
    }
    
    function dd($var)
    {
        var_dump($var);
        die();
    }
    
    function get_timestamp()
    {
        return strftime("%Y-%m-%d %H:%M:%S", time());
    }
    
    function fsize($bytes, $decimals = 0)
    {
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }
    
    function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
