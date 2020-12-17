<?php
unset($_COOKIE['logged']);
unset($_COOKIE['medico']);
unset($_COOKIE['nome']);
setcookie('logged', '', time() - 3600, '/');
setcookie('medico', '', time() - 3600, '/');
setcookie('nome', '', time() - 3600, '/');
header("Location:login/");
exit();

