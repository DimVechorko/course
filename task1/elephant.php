#!/usr/bin/php5
<?php
$name = "";
$exit = "";
$str = "";
$stdin = fopen('php://stdin', 'r');
if ($name == "") {echo "Введите свое имя:";}
$name = trim(fgets(STDIN));
if(empty($name == true)) { $name = "Anonymos";}
while ($str == "") {
    echo "\033[32m$name\e[0m, купи слона \n";
    $str = trim(fgets(STDIN));
}
while ($exit != "0") {
    echo "\033[32m$name \e[0m, каждый может сказать \033х47m\033[35m$str\e[0m, а ты купи слона \n";
    $str = trim(fgets(STDIN));
    $exit = strcasecmp($str, "exit");
}
?>