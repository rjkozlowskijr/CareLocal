<?php 
    $host = 'sql100.infinityfree.com';    
    $data = 'if0_37494184_bcs325'; 
    $user = 'if0_37494184';         
    $pass = 'ng83mrv4';        
    $chrs = 'utf8mb4';
    $attr = "mysql:host=$host;dbname=$data;charset=$chrs";
    $opts =
    [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
?>