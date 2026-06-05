<?php 
//logout.php

session_start();
session_unset(); //limpiamos las variables
session_destroy(); //destruimos la sesion
header("Location: login.php");
exit();


?>