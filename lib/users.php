<?php
function count_users(){
    global  $db;
    $result = $db->query("
        SELECT *
        FROM users
            ");
    $count = $result->num_rows;
    return $count;
}

function get_all_users(){
    global $db;
    $result = $db->query("
            SELECT *
            FROM users
            WHERE 1
            ");
    $users= array();
    while ($row = $result->fetch_assoc()){
        $users[] = $row;
    }
    return $users;
}

function get_user ($username){
    if (!$username){
        return;
    }
    global $db;
    $result = $db->query("
        SELECT *
        FROM users
        WHERE username = '$username'
        ");
    
    $row = $result->fetch_assoc();
    return $row;
}

function user_exists($username){
    if (!get_user($username)){
        return FALSE;
    }
    return TRUE;
}

function add_user($userdata){
    foreach ($userdata as $item){
        $username = $item['username'];
        $password = sha1($item['password']);
        $first_name = $item['first_name'];
        $last_name =$item['last_name'];
        $image_name = $item['img_name'];
        $image_dir = $item['img_dir'];
        $access_level = $item['access_level'];
    }
    if(!$username){
        return;
    }
    if (!$password){
        return;
    }
    global $db;
        $db->query("
            INSERT INTO users (username , password , first_name , last_name ,img_name , img_dir , access_level) VALUES
            ('$username' , '$password' ,'$first_name' , '$last_name' , '$image_name' , '$image_dir' , '$access_level');
                ");
   
}


function update_user($userdata) {
        foreach ($userdata as $item){
        $username = $item['username'];
        $password = sha1($item['password']);
        $first_name = $item['first_name'];
        $last_name =$item['last_name'];
        $image_name = $item['img_name'];
        $image_dir = $item['img_dir'];
        $access_level = $item['access_level'];
        $id = $item['id'];
    }
    if(!$username){
        return;
    }
    if (!$password){
        return;
    }
    global $db;
    $db->query("
        UPDATE `users` SET `username` = '$username', `password` = '$password', `first_name` = '$first_name', `last_name` = '$last_name', `img_name` = '$image_name', `img_dir` = '$image_dir',`access_level` = '$access_level'  WHERE `users`.`id` = '$id';   
              ");
}

function get_user_edit_url($id){
    return home_url("one-user-edit?id=$id");
}

function get_user_delete_url($id){
    return home_url("users-edit?action=delete&id=$id");
}

function get_user_by_id($id){
    if (empty($id)){
        return;
    }
    global $db;
    $result = $db->query("
        SELECT *
        FROM users
        WHERE id = '$id';
            ");
    $row = $result->fetch_assoc();
    return $row;
}

function delete_user_by_id($id){
    if (empty($id)){
        return;
    }
    global $db;
    $db->query("
        DELETE FROM users
        WHERE id = '$id';
            ");
}

function delete_user($username){
    if(!user_exists($username)){
        return;
    }
    global $db;
    $db->query("
        DELETE FROM users
        WHERE username = '$username';
            ");
}

