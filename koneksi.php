<?php
$server="localhost";
$username="root";
$password="";
$db="akademik";

$koneksi = mysql_connect($server, $username, $password) or die("tidak bisa connect!");
mysql_select_db($db, $koneksi) or die("database tidak bisa connect!");
?>