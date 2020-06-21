<?php

function count_pages($include_hidden = FALSE){
    global $db;
    if ($include_hidden){
        $result = $db->query("
            SELECT *
            FROM pages
            WHERE 1
            ");
    } else {
        $result = $db->query("
            SELECT *
            FROM pages
            WHERE hidden = 0
            ");
    }        
    $row = $result->num_rows;
    return $row;
}

function get_page($slug){
    if (!$slug){
        return;
    }
    global $db;
    $result = $db->query("
            SELECT *
            FROM pages
            WHERE slug = '$slug'
            ");
    $row = $result->fetch_assoc();
    return $row;
}

function get_page_by_id($id){
    if (!$id){
        return;
    }
    global $db;
    $result = $db->query("
            SELECT *
            FROM pages
            WHERE id = '$id'
            ");
    $row = $result->fetch_assoc();
    return $row;
}

function get_page_by_title($title){
    if (!$title){
        return;
    }
    global $db;
    $result = $db->query("
            SELECT *
            FROM pages
            WHERE title = '$title'
            ");
    $row = $result->fetch_assoc();
    return $row;
}

function get_all_pages($include_hidden = FALSE){
    global $db;
    if ($include_hidden){
        $result = $db->query("
                SELECT *
                FROM pages
                WHERE 1
                ");
    } else {
        $result = $db->query("
                SELECT *
                FROM pages
                WHERE hidden = 0
                ");
    }
    $pages = array();
    while ($row = $result->fetch_assoc()){
        $pages [] = $row;
    }
    return $pages;
}

function page_exists($slug){
    if (!$slug){
        return FALSE;
    }
    if (!get_page($slug)){
        return FALSE;
    }
    return TRUE;
}

function page_exists_by_title($title){
    if (!$title){
        return FALSE;
    }
    if (!get_page_by_title($title)){
        return FALSE;
    }
    return TRUE;
}

function add_page ($title , $slug , $content , $image_name , $image_dir ,$hidden = FALSE){
    if (!$title && !$slug && !$content){
        echo 'برای ساخت یک برگه پر کردن تمامی فیلد ها الزامی است';
        return;
    }
    if (get_page_by_title($title)){
        echo 'برگه با عنوان موردنظر شما موجود می باشد!لطفا از عنوان دیگری استفاده کنید.';
        return;
    }
    
    global $db;
    
        $db->query("
            INSERT INTO pages (title , slug , content , img_name , img_dir , hidden) VALUES ('$title' , '$slug' , '$content' , '$image_name' , '$image_dir' , '$hidden');
                ");
}

function update_page($title , $slug , $content , $image_name , $image_dir ,$hidden = FALSE){
    add_page($title, $slug, $content , $image_name , $image_dir , $hidden);
}

function update_page_by_id($id , $title , $slug , $content , $image_name , $image_dir ,$hidden){
    if (!$id){
        return;
    }
    
    global $db;
    $db->query("
            UPDATE pages
            SET title = '$title' , slug = '$slug' , content = '$content' , img_name = '$image_name' , img_dir = '$image_dir' , hidden = '$hidden'
            WHERE id = '$id'    
            ");
}

function delete_page($slug){
    if (!$slug){
        return;
    }
    global $db;
    $db->query("
        DELETE FROM pages
        WHERE slug = '$slug'
            ");
}

function get_page_title($id){
    $pagedata = get_page_by_id($id);
    if (!$pagedata['id']){
        return NULL;
    }
    $title = $pagedata['title'];
    return $title;
}

function get_page_slug($id){
    $pagedata = get_page_by_id($id);
    if (!$pagedata['id']){
        return NULL;
    }
    $slug = $pagedata['slug'];
    return $slug;
}

function get_page_content($id){
    $pagedata = get_page_by_id($id);
    if (!$pagedata['id']){
        return NULL;
    }
    $content = $pagedata['content'];
    return $content;
}

function get_page_url($id){
    $slug = get_page_slug($id);
    $url = SITE_URL . $slug;
    return $url;
}

function is_page_hidden($id){
    $page_info = get_page_by_id($id);
    if (!$page_info['hidden']){
        return FALSE;
    }
    return TRUE;
}

function get_page_edit_url($id){
    return home_url("edit?id=$id");
}

function get_page_hide_url($id){
    return home_url("edit-pages?action=hide&id=$id");
}

function get_page_unhide_url($id){
    return home_url("edit-pages?action=unhide&id=$id");
}

function get_page_delete_url($id){
    return home_url("edit-pages?action=delete&id=$id");
}

function hide_page($id){
    $page = get_page_by_id($id);
    if (!$page){
        return;
    }
    $page['hidden']=1;
    update_page_by_id($id , $page['title'], $page['slug'], $page['content'], $page['img_name'] , $page['img_dir'] , $page['hidden']);
}

function unhide_page($id){
    $page = get_page_by_id($id);
    if (!$page){
        return;
    }
    $page['hidden']=0;
    update_page_by_id($id , $page['title'], $page['slug'], $page['content'], $page['img_name'] , $page['img_dir'] , $page['hidden']);
}

function delete_page_by_id($id){
    if (!$id){
        return;
    }
    global $db;
    $db->query("
        DELETE FROM pages
        WHERE id = '$id'
            ");
}

function display_pages_list($add_ul = TRUE){
    $pages = get_all_pages();
    if (!$pages){
        return;
    }
    if ($add_ul){
        echo '<ul>';
    }
    foreach ($pages as $page){
        if ($page['hidden']){
            Continue;
        }
        $slug = $page['slug'];
        $url = SITE_URL . $slug;
        echo '<li>';
        echo '<a href ='."$url".'>'.$page['title'].'</a>';
        echo '</li>';
    }
    if($add_ul){
        echo '</ul>';
    }
}


