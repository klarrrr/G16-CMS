<?php

session_start();
session_unset();
session_destroy();

header('Location: ../lundayan-sign-in-page.php');
exit;
