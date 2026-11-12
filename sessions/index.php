<?php
ini_set('session.gc_maxlifetime', 10800);
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
session_save_path('C:/xampp/htdocs/nsimrs/sessions');
session_start();

echo 'ok';
?>