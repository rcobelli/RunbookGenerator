<?php

include_once("init.php");

session_destroy();
setcookie("runbook", null, 1, '/');
header("Location: index.php");
