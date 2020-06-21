<?php

function get_title(){
    echo 'ویرایش برگه';
}

function get_content(){ 
    $id = $_GET['id'];
    global $pages;
    $pages = get_page_by_id($id);
    
    if (!$pages){
        add_message('صفحه مورد نظر یافت نشد!', 'error');
        return;
    }
    ?>
    
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-primary">
            <div class="panel-heading">
            <h3 class="panel-title">ویرایش برگه</h3>
            </div>
            <div class="panel-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="title">عنوان صفحه</label>
                      <input type="text" name="title" class="form-control" id="title" value="<?php echo $pages['title']; ?>" placeholder="عنوان صفحه">
                    </div>
                    <div class="form-group">
                      <label for="slug">نامک</label>
                      <input type="text" name="slug" class="form-control" id="slug" value="<?php echo $pages['slug']; ?>" placeholder="نامک">
                    </div>
                    <div class="form-group">
                        <label for="content">محتوای برگه</label>
                        <br>
                        <textarea id="content" name="content" class="form-control" rows="20"  placeholder="محتوای یرگه"><?php echo $pages['content']; ?></textarea>
                    </div> 
                    <div class="form-group">
                        <label for="image">آپلود عکس</label>
                        <input type="file" id="image" name="image">
                        <p class="help-block">عکس پایین صفحه را می توانید اینجا آپلود کنید.با آپلود عکس جدید عکس قبلی حذف خواهد شد!</p>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="hidden" id="hidden" <?php echo $pages['hidden'] ? 'checked' : ''; ?>>
                          مخفی کردن
                        </label>
                    </div>
                    <button type="submit" name="save" id="save" class="btn btn-primary">ذخیره</button>
                </form>
            </div>
            </div>
        </div>
    </div>
    
        <!-- TinyMCE scriots -->
       
        <script src="https://cdn.tiny.cloud/1/htkl4a2on3r4jn6rtv9jq0ntbou2rc7csya7567l16l3cgsx/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
          tinymce.init({
            selector: 'textarea#content',
            plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
            toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
            toolbar_mode: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name'
          });
        </script>
  
<?php } 

 function process_inputs(){
     if (empty($_POST)){
         return;
     }
     
      global $pages;
     $pages = $_POST;
     $pages['id'] = $_GET['id'];
     
     if (isset($pages['hidden']) && $pages['hidden'] == 'on'){
         $pages['hidden'] = 1;
     } else {
         $pages['hidden'] = 0; 
     }
     
     global $db;
     $file_temp = $_FILES['image']['tmp_name'];
     $file_dir = 'uploads/';
     $file_name = basename($_FILES['image']['name']);
     $target = $file_dir . $file_name;
     $file_type = pathinfo($target , PATHINFO_EXTENSION);
     
     if (isset($_POST['save']) && isset($_FILES['image']['name'])){
    
        move_uploaded_file($file_temp, $target);
        $upload = update_page_by_id($pages['id'], $pages['title'], $pages['slug'], $pages['content'] , $file_name , $target , $pages['hidden']);
        add_message('برگه شما با موفقیت ویرایش شد.', 'success');
    } else {
        add_message('فایلی بارگذاری نشده است و یا فایل بارگذاری شده نامعتبر است!', 'error');
    }     
    }
    

