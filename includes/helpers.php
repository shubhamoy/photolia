<?php
    require_once('config.php');

    function check_db()
    {
        // Initiate DB Connection 
        if(defined('DBNAME') && DBNAME !== '') {
            
            $link = @mysqli_connect(HOST, USER, PWD, DBNAME);
            
            if(!$link) {
                echo "<h1>Database Connection Failed :(</h1>";
                die();
            } else {
                $r = mysqli_num_rows(mysqli_query($link, 'SHOW TABLES'));
                if($r < 1) {
                    echo "<h1>Tables Missing.</h1>"; 
                    die();
                }
            }
            @mysqli_close($link);
            return true;
        } else {
            return false;
        }
    }

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

    function getIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])){
            //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } 
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }