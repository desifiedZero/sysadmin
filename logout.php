<?php

setcookie('user', null, time() - 1);
setcookie('role', null, time() - 1);

header("Location: login.php");

?>