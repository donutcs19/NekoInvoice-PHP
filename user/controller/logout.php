<?php

session_start();
unset($_SESSION['user_id']);
unset($_SESSION['user_urole']);
session_destroy();
header("Location: ../../index.php");
exit();