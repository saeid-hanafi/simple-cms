<?php

global $db;
$db = new mysqli(MYSQL_SERVER, MYSQL_USERNAME, sha1(MYSQL_PASSWORD), MYSQL_DBNAME);
$db->set_charset("utf8");