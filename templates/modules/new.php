<?php

function get_title(){
    echo 'ایجاد برگه جدید';
}

function get_content(){ ?>
    
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
                      <input type="text" name="title" class="form-control" id="title" placeholder="عنوان صفحه">
                    </div>
                    <div class="form-group">
                      <label for="slug">نامک</label>
                      <input type="text" name="slug" class="form-control" id="slug" placeholder="نامک">
                    </div>
                    <div class="form-group">
                        <label for="content">محتوای برگه</label>
                        <br>
                        <textarea id="content" name="content" class="form-control" rows="10" placeholder="محتوای یرگه"><?php ?></textarea>
                    </div> 
                    <div class="form-group">
                        <label for="image">آپلود عکس</label>
                        <input type="file" id="image" name="image">
                        <p class="help-block">عکس پایین صفحه را می توانید اینجا آپلود کنید.با آپلود عکس جدید عکس قبلی حذف خواهد شد!</p>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="hidden" id="hidden" value="">
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
     
     $pages = $_POST;
     
     if (page_exists($pages['slug'])){
        add_message('برگه با این نامک قبلا ساخته شده است!', 'error');
        return;
     }
     
     if (isset($pages['hidden']) && $pages['hidden'] = 'on'){
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
        $insert = add_page($pages['title'], $pages['slug'], $pages['content'] , $file_name , $target , $pages['hidden']);
     } 
     
     $new_page = get_page($pages['slug']);
     $id = $new_page['id'];
     redirect_to(get_page_edit_url($id));
 }

