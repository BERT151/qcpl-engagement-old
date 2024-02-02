<?php
    if($_SERVER['SERVER_NAME'] == 'localhost'){
        // database config
        define('DBNAME', 'qcpl_engagement');
        define('DBHOST', 'localhost');
        define('DBUSERNAME', 'root');
        define('DBPASSWORD', '');
        define('DBDRIVER', '');

        // absolute path    
        define('ROOT', '../../public');
    }else{
        // database config
        define('DBNAME', 'qcpl_engagement');
        define('DBHOST', 'localhost');
        define('DBUSERNAME', 'root');
        define('DBPASSWORD', '');
        define('DBDRIVER', '');

        // absolute path
        define('ROOT', 'http://localhost/qcpl-engagement/public');
    }