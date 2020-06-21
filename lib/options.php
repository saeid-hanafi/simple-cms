<?php

function get_option($option_name , $full_row = FALSE){
    if(!$option_name){
        return;
    }
    global $db;
    $result = $db->query("
            SELECT *
            FROM options
            WHERE option_name = '$option_name';
            ");
    $row = $result->fetch_assoc();
    
    if($row){
        if ($full_row){
            return $row;
        } else {
            return $row['option_value'];
        }
    } else {
        return FALSE;
    }
}

function option_exists($option_name){
    if (!get_option($option_name)){
        return FALSE;
    }
    return TRUE;
}

function add_option($option_name , $option_value){
    if (!$option_name){
        return FALSE;
    }
    if(!$option_value){
        $option_value = 1;
    }
    
    global $db;
    if (!option_exists($option_name)){
         $db->query("
             INSERT INTO options (option_name , option_value) VALUES
             ('$option_name' , '$option_value');
            ");
    } else {
        $db->query("
            UPDATE options
            SET option_value = '$option_value'
            WHERE option_name = '$option_name';    
                ");
    }
}

function update_option($option_name , $option_value){
    add_option($option_name, $option_value);
}

function delete_option($option_name){
    if (!$option_name){
        return;
    }
    global $db;
    $db->query("
        DELETE FROM options
        WHERE option_name = '$option_name';
            ");
}