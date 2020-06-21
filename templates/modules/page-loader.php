<?php

function get_title(){
    global $current_page;
    echo $current_page['title'];
}

function get_content(){
    global $current_page;
    echo '<p>';
    echo $current_page['content'];
    echo '</p>';
    if (!empty($current_page['img_name'])){
    echo '<div class = "image" style = "padding-top: 10px;">'; 
    ?>
   <img style = "width: 100%;
    height: -webkit-fill-available;
    border: 2px solid gray;
    border-radius: 15px;" src = "uploads/<?php echo $current_page['img_name']; ?>" alt = "">
<?php   
    echo '</div>';

}
$id = $current_page['id'];

if (is_user_loggen_in()){
?>
<br>
<br>
<a class="btn btn-info btn-lg" href="<?php echo get_page_edit_url($id); ?>">ویرایش</a>

<?php }
}