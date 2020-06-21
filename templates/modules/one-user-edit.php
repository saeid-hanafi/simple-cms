<?php

function get_title(){
    echo 'ویرایش کاربر';
}

function get_content(){ 
    $id = $_GET['id'];
    global $users;
    $users = get_user_by_id($id);
    
    if (!$users){
        add_message('کاربر مورد نظر یافت نشد!', 'error');
        return;
    }
    ?>
    
       <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-primary">
            <div class="panel-heading">
            <h3 class="panel-title">ویرایش کاربر</h3>
            </div> 
            <div class="panel-body">
                <form method="post" enctype="multipart/form-data" name="myform" action="">
                    <input type="hidden" name="length" value="12">
                    <div class="form-group">
                      <label for="firstname">نام</label>
                      <input type="text" name="firstname" class="form-control" id="firstname" value="<?php echo $users['first_name']; ?>" placeholder="نام" oninvalid="setCustomValidity('پرکردن این فیلد الزامی است!')" oninput="setCustomValidity('')" required>
                    </div>
                    <div class="form-group">
                      <label for="lastname">نام خانوادگی</label>
                      <input type="text" name="lastname" class="form-control" id="lastname" value="<?php echo $users['last_name']; ?>" placeholder="نام خانوادگی" oninvalid="setCustomValidity('پرکردن این فیلد الزامی است!')" oninput="setCustomValidity('')" required>
                    </div>
                    <div class="form-group">
                      <label for="username">نام کاربری</label>
                      <input type="text" name="username" class="form-control" id="username" value="<?php echo $users['username']; ?>" placeholder="نام کاربری" oninvalid="setCustomValidity('پرکردن این فیلد الزامی است!')" oninput="setCustomValidity('')" required>
                    </div>
                    <div class="form-group">
                        <label for="password">رمز عبور</label>
                        <input type="password" class="attr" id="password" name="password" placeholder="رمز عبور" value = "<?php echo $users['password']; ?>" oninvalid="setCustomValidity('پرکردن این فیلد الزامی است!')" oninput="setCustomValidity('')" required>
                        <span class="glyphicon glyphicon-eye-open" id="pass-icon" onclick="passfunction()" aria-hidden="true"></span>
                        <input type="button" class="button" value="رمز عبور پیشنهادی" onClick="generate();" tabindex="2">
                    </div> 
                    <div class="form-group">
                        <label for="confirmpass">تکرار رمز عبور</label>
                        <input type="password" id="confirmpass" name="confirmpass" placeholder="تکرار رمز عبور" value = "<?php echo $users['password']; ?>" oninvalid="setCustomValidity('پرکردن این فیلد الزامی است!')" oninput="setCustomValidity('')" required>
                        <span class="glyphicon glyphicon-eye-open" id="confirmpass-icon" onclick="confirmpassfunction()" aria-hidden="true"></span>
                    </div> 
                    <div class="form-group">    
                        <label for="access-level">سطح دسترسی</label>
                        <select class="form-control access" id="access-level" name="access-level">
                            <option value="3">کاربر معمولی</option>
                            <option value="2">مدیر</option>
                            <option value="1">برنامه نویس</option>
                        </select>
                    </div>     
                    <div class="form-group">
                        <label for="image">آپلود عکس</label>
                        <input type="file" id="image" name="image">
                        
                        <p class="help-block">لطفا در هر ویرایش، عکس مورد نظر را دوباره بارگذاری کنید.</p>
                    </div>
      
                    <button type="submit" name="save" id="save" class="btn btn-primary">ذخیره</button>
                </form>
            </div>
            </div>
        </div>
    </div>
            <script>
                function passfunction() {
                var x = document.getElementById("password");
                var y = document.getElementById("pass-icon");
                if (x.type === "password") {
                  x.type = "text";
                  y.className = "glyphicon glyphicon-eye-close";
                } else {
                  x.type = "password";
                  y.className = "glyphicon glyphicon-eye-open";
                }
                } 
                
                 function confirmpassfunction() {
                var x = document.getElementById("confirmpass");
                var y = document.getElementById("confirmpass-icon");
                if (x.type === "password") {
                  x.type = "text";
                  y.className = "glyphicon glyphicon-eye-close";
                } else {
                  x.type = "password";
                  y.className = "glyphicon glyphicon-eye-open";
                }
                } 

                function randomPassword(length) {
                    var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOP1234567890";
                    var pass = "";
                    for (var x = 0; x < length; x++) {
                        var i = Math.floor(Math.random() * chars.length);
                        pass += chars.charAt(i);
                    }
                    return pass;
                }

                function generate() {
                   myform.confirmpass.value = myform.password.value = randomPassword(myform.length.value);
                    
                }
                
                $('input[type="text"]')
            	.on('invalid', function(){
            		return this.setCustomValidity('Ingresa una dirección de correo válida.');
            	})
            	.on('input', function(){
            		return this.setCustomValidity('');
            	});
            	
            	$('input[type="password"]')
            	.on('invalid', function(){
            		return this.setCustomValidity('Ingresa una dirección de correo válida.');
            	})
            	.on('input', function(){
            		return this.setCustomValidity('');
            	});
            </script>
  
<?php } 

 function process_inputs(){
     if (empty($_POST)){
         return;
     }
     $password = $_POST['password'];
     $confirm_pass = $_POST['confirmpass'];
     if ($password !== $confirm_pass){
         add_message('رمز عبور و تکرار آن با هم برابر نیستند!', 'error');
         return;
     }
     global $users;
     $users = $_POST;
     $users['id'] = $_GET['id'];
     $username = $_POST['username'];
     
     
     global $db;
     $file_temp = $_FILES['image']['tmp_name'];
     $file_dir = 'uploads/';
     $file_name = basename($_FILES['image']['name']);
     $target = $file_dir . $file_name;
     $file_type = pathinfo($target , PATHINFO_EXTENSION);
     if (isset($_POST['save']) && isset($_FILES['image']['name'])){
         
        move_uploaded_file($file_temp, $target);
        $userdata[] = array(
            'username' => $username,
            'password' => $password,
            'first_name' => $users['firstname'],
            'last_name' => $users['lastname'],
            'img_name' => $file_name,
            'img_dir' => $target,
            'id' => $users['id'],
            'access_level' => $users['access-level'],
        );
        
        update_user($userdata);
        add_message('اطلاعات کاربری با موفقیت ویرایش شد.', 'success');
     } else {
         add_message('ثبت اطلاعات کاربری با خطا انجام شد!لطفا دوباره تلاش کنید.', 'error');
     }     
     
 }

