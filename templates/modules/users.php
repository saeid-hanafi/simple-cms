<?php

function get_title(){
    echo 'ویرایش کاربران';
}

function get_content(){ ?>
    
   <table class="table table-bordered table-striped">
        
       <?php if (!empty(get_all_pages(TRUE))){ ?>
       
       <tr class="info">
           <th style="width: 5%;text-align: center;">ردیف</th>
           <th style="text-align: center;">عنوان</th>
           <th style="text-align: center;">عملیات</th>
       </tr>
       
       <?php } ?>
       
        <?php 
            $pages = get_all_pages(TRUE); 
            $counter = 0;
            foreach ($pages as $page){
                $counter++;
                $id = $page['id'];
                $title = $page['title'];
                $hidden = $page['hidden'];
       ?>
       <tr>
           <td style="width: 5%;text-align: center;">
               <?php  echo $counter; ?>
           </td>
           <td>
               <?php echo '<strong>'.$title.'</strong>'; 
               if ($hidden){
                   echo '<span style = "color:tomato;"> [مخفی]</span>';    
               } ?>
               <br>
               <a href="<?php echo get_page_url($id); ?>" style="text-decoration: none;color: #31b0d5;"><?php echo get_page_url($id); ?></a>
           </td>
           <td style="text-align: center; line-height: normal;">
               <a class="btn btn-info btn-xs" href="<?php echo get_page_edit_url($id); ?>">ویرایش</a>
               <?php 
               if ($hidden): ?>
               <a class="btn btn-success btn-xs" href="<?php echo get_page_unhide_url($id); ?>">ظاهر کردن</a>
               <?php else : ?>
               <a class="btn btn-warning btn-xs" href="<?php echo get_page_hide_url($id); ?>">مخفی کردن</a>
               <?php endif; ?>
               <a class="btn btn-danger btn-xs" href="<?php echo get_page_delete_url($id); ?>">حذف</a>
           </td>
       </tr>
       <?php } ?>
   </table>
                <a class="btn btn-info" href="<?php echo home_url('new'); ?>">صفحه جدید</a>
<?php } 

 function process_inputs(){
     if (empty($_GET)){
         return;
     }
   
     $action = strtolower($_GET['action']);
     $id = $_GET['id'];
     
     switch ($action) :
        case 'hide':
            hide_page($id);
            break;
         case 'unhide':
             unhide_page($id);
             break;
         case 'delete':
             delete_page_by_id($id);
             break;
     endswitch;
     
     redirect_to(home_url('edit-pages'));
 } 