<?php
function get_title(){
    echo 'ورود';
}

function get_content(){
?>
<div class="row">
  <div class="col-xs-2 col-md-2"></div>  
  <div class="col-xs-8 col-md-8">
    <div class="panel panel-primary">
        <div class="panel-heading">
        <h3 class="panel-title">ورود</h3>
        </div>
    <div class="panel-body">
        <form method="post">
            <div class="form-group">
              <label for="username">نام کاربری</label>
              <input type="text" name="username" class="form-control" id="username" placeholder="نام کاربری">
            </div>
            <div class="form-group">
              <label for="password">رمز عبور</label>
              <input type="password" name="password" class="form-control" id="password" placeholder="رمز عبور">
              <br>
              <input type="checkbox" onclick="passfunction()">
              <span>نمایش رمز عبور</span>
            </div>
            <button type="submit" name="login" id="login" class="btn btn-default">ورود</button>
        </form>
    </div>
    </div>
  </div>
  <div class="col-xs-2 col-md-2"></div>
</div>

            <script>
                function passfunction() {
                var x = document.getElementById("password");
                if (x.type === "password") {
                  x.type = "text";
                } else {
                  x.type = "password";
                }
                }    
            </script>

<?php
}

function process_inputs() {
    
    if(!isset($_POST['login'])) {
        return;
    }
    
    if(isset($_POST['username'])) {
        $username = $_POST['username'];
    }

    if(empty($username)) {
        add_message('نام کاربری نمی تواند خالی باشد.', 'error');
        return;
    }
    
    if(isset($_POST['password'])) {
        $password = $_POST['password'];
    }
    
    if(empty($password)) {
        add_message('رمز عبور نمی تواند خالی باشد.', 'error');
        return;
    }
    
    user_login($username, $password);
    
    if(is_user_loggen_in() === FALSE) {
        add_message('نام کاربری یا رمز عبور، اشتباه است.', 'error');
    } else {
        redirect_to(home_url());
    }
    
}