<?php

function get_title(){
    echo 'ویرایش کاربران';
}

function get_content(){ ?>
    
   <table class="table table-bordered table-striped">
       <tr class="info">
           <?php if (!empty(get_all_users())){ ?>
           <th style="width: 5%;text-align: center;">ردیف</th>
           <th style="text-align: center;">نام کاربری</th>
           <th style="text-align: center;">نام</th>
           <th style="text-align: center;">نام خانوادگی</th>
           <th style="text-align: center;">سطح دسترسی</th>
           <th style="text-align: center;">عملیات</th>
       </tr>
           <?php } ?>
       <?php $users = get_all_users(); 
            $counter = 0;
            foreach ($users as $user){
                $counter++;
                $id = $user['id'];
                $username = $user['username'];
                $first_name = $user['first_name'];
                $last_name = $user['last_name'];
            
       ?>
       <tr style="text-align: center;">
           <td style="width: 5%;text-align: center;">
               <?php  echo $counter; ?>
           </td>
           <td>
               <?php echo '<strong>'.$username.'</strong>'; ?>
           </td>
           <td>
               <?php echo $first_name; ?>
           </td>
           <td>
               <?php echo $last_name; ?>
           </td>
           <td>
               1
           </td>
           <td style="text-align: center; line-height: normal;">
               <a class="btn btn-info btn-xs" href="<?php echo get_user_edit_url($id); ?>">ویرایش</a>
               <a class="btn btn-danger btn-xs" href="<?php echo get_user_delete_url($id); ?>">حذف</a>
           </td>
       </tr>
       <?php } ?>
   </table>
                <a class="btn btn-info" href="<?php echo home_url('new-user'); ?>">کاربر جدید</a>
<?php } 

 function process_inputs(){
     if (empty($_GET)){
         return;
     }
     $action = strtolower($_GET['action']);
     $id = $_GET['id'];
     
     if ($action == 'delete'){
         delete_user_by_id($id);
     }
     
     redirect_to(home_url('users-edit'));
 }
