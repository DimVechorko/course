#!/usr/bin/php5
<?php
$exit = "";
$str = "";

if(empty($argv[1])) { $name = "Anonymos";} else {$name = $argv[1];}
while ($str == "") {
    echo "\033[32m$name\e[0m, купи слона \n";
    $str = trim(fgets(STDIN));
}
while ($exit != "0") {
    if (empty($str)) {echo "\033[32m$name\e[0m, купи слона \n";}else {
        echo "\033[32m$name \e[0m, каждый может сказать \033х47m\033[35m$str\e[0m, а ты купи слона \n";
    }
    $str = trim(fgets(STDIN));
    $exit = strcasecmp($str, "exit");
}
