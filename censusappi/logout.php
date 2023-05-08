<?php
session_start();
$_SESSION = array();
echo "<script>";
echo "window.location = 'index.php'";
echo "</script>";

?>