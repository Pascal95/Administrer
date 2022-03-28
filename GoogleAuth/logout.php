<?php
require('./config.php');

$_SESSION = [];
session_destroy();
header('location:http://localhost:8888/MSPRWEB/GoogleAuth/index.php');
?>