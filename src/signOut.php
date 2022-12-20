<?php
session_start();
session_unset();
if (isset($_COOKIE[session_name()])){
    setcookie(session_name(), 0, time() - 60*60*12, '/');
}
session_destroy();
header('location: ../signIn.php?signOut=1');
exit();