<?php

$current_user = null;
$current_user_id = null;

define('SESSION_EXPIRATION_TIME', 24*3600);

function get_current_user_data() {
    global $current_user;
    return $current_user;
}

function get_current_user_id() {
    global $current_user_id;
    return $current_user_id;
}

function is_user_loggen_in() {
    global $current_user_id;
    if($current_user_id) {
        return TRUE;
    }
    return FALSE;
}

function clear_user_session() {
    unset($_SESSION['last_access']);
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
    unset($_SESSION['password']);
}

function check_for_previous_login() {
    
    $last_access = 0;
    if(isset($_SESSION['last_access'])) {
        $last_access = $_SESSION['last_access'];
    }
    $expired = ((time() - $last_access) > SESSION_EXPIRATION_TIME);
    if($expired) {
        session_unset();
        clear_user_session();
        return;
    }
    
    $username = $_SESSION['username'];
    
    $user = get_user($username);
    if($user) {
        $user_id = $_SESSION['user_id'];
        if($user_id != $user['id']) {
            session_unset();
            clear_user_session();
            return;
        }
        
        $password = $_SESSION['password'];
        if($password != $user['password']) {
            session_unset();
            clear_user_session();
            return;
        }
        
        global $current_user;
        global $current_user_id;
        
        $current_user = $user;
        $current_user_id = $user['id'];
    }
}

function user_logout() {
    global $current_user;
    global $current_user_id;
    $current_user = null;
    $current_user_id = null;
    session_unset();
    clear_user_session();
}

function user_login($username, $password) {
    
    session_unset();
    clear_user_session();
    
    $user = get_user($username);
    if(!$user) {
        return;
    }
    
    if(sha1($password) !== $user['password']) {
        return;
    }
    
    global $current_user;
    global $current_user_id;
    
    $current_user = $user;
    $current_user_id = $user['id'];
    
    $_SESSION['last_access'] = time();
    $_SESSION['user_id'] = $current_user_id;
    $_SESSION['username'] = $user['username'];
    $_SESSION['password'] = $user['password'];
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['last_name'] = $user['last_name'];
    $_SESSION['image_name'] = $user['img_name'];
    $_SESSION['image_dir'] = $user['img_dir'];
    $_SESSION['access_level'] = $user['access_level'];
}