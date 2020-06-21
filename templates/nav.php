<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo home_url(); ?>">
                پروژه اول
            </a>
        </div>

        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo home_url(); ?>">صفحه اصلی</a></li>
                <?php display_pages_list(false); ?>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php if(is_user_loggen_in() === FALSE): ?>
                    <li><a href="<?php echo home_url('login'); ?>">ورود</a></li>  
                <?php else: ?>
                    <li>
                        <?php $image_name = $_SESSION['image_name']; ?>
                        <?php if (!empty($image_name)){ ?>
                        <img class="user-image" src="uploads/<?php echo $image_name; ?>">
                        <?php } ?>
                        <p class="navbar-text">
                        سلام
                        <?php $current_user = $_SESSION['username']; ?>
                        <strong><?php echo $current_user; ?></strong>
                        </p>
                    </li>
                    <?php 
                    $access_level = $_SESSION['access_level'];
                    if ($access_level === '1') {
                    ?>
                    <li><a href="<?php echo home_url('users-edit'); ?>">ویرایش کاربران</a></li>
                    <?php }
                    if ($access_level === '1' || $access_level === '2') {
                    ?>
                    <li><a href="<?php echo home_url('edit-pages'); ?>">ویرایش برگه ها</a></li>
                    <?php }
                    if ($access_level === '1' || $access_level === '2' || $access_level === '3') {
                    ?>
                    <li><a href="<?php echo home_url('dashboard'); ?>">صفحه کاربری</a></li>
                    <?php } ?>
                    <li><a href="<?php echo home_url('logout'); ?>">خروج</a></li>
                <?php endif; ?>
                <!--
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </li>
                -->
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>