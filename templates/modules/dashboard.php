<?php

function authentication_required() {
    return true;
}

function get_title(){
    echo 'صفحه کاربری';
}

function get_content(){
    echo '<p>';
    echo 'محتویات این برگه فقط برای کاربران قابل نمایش می باشد.';
    echo '</p>';
}