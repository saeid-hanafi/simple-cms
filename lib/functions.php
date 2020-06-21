<?php

function home_url($path = NULL){
    if (!$path || $path == '/'){
        return SITE_URL;
    }
    return SITE_URL . $path;
}

function get_module_name(){
    $url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    
    $req = str_replace(SITE_URL, '', $url);
    $question_marks = strpos($req, '?');
    
    if ($question_marks !== FALSE){
        $req = substr($req, 0, $question_marks);
    }
    return $req;  
}

function is_valid_url($url){
    if (empty($url)){
        return FALSE;
    }
    if (filter_var($url , FILTER_VALIDATE_URL)){
        return TRUE;
    }
    return FALSE;
}

function redirect_to($url){
    if (empty($url)){
        if (is_valid_url($url) === FALSE){
            return;
        }
    }
    header("Location: $url");
    die();
}

function filter_inputs($input_name){
    return trim(htmlspecialchars(stripslashes($input_name)));
}

function get_inputs($input_name , $array){
    if(isset($array[$input_name])){
        return filter_inputs($array[$input_name]);
    }
    return NULL;
}



