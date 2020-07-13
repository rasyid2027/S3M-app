<?php 

// echo "ok";
session_start();
$_SESSION = [];
session_unset();
session_destroy();

header("Location: auth-login.php");
exit;

?>
