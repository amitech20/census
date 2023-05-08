<?php
    $dev =true;
    if(!$dev){
        $ROUTE="";
        if(!isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'on'){
            $link = "https://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; 
            echo"<script>window.location.assign('$link')</script>";
        }
        $host = 'localhost'; $dbname = 'capizwug_normandy'; $user = 'capizwug_mrnormandy'; $pass = 'Workman030';
    }
    else{
        // $ROUTE="Whiteboard/normandy";
        $host = 'localhost'; $dbname = 'census_app'; $user = 'root'; $pass = '';
    }
    
    # connect to the database
    try {
        $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        $DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); # set error attribute
    }
    catch(PDOException $e) {
        echo $e->getMessage(); # log errors to a file
    }

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $con = mysqli_connect($host,$user,$pass,$dbname);   
    /* change character set to utf8mb4 */
    mysqli_set_charset($con, "utf8");
?>