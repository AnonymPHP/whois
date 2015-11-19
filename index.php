<?php

include "vendor/autoload.php";

use Anonym\Whois;
$whois = new Whois('kophack.com');

print_r($whois->getResult());

var_dump($whois->parseData());