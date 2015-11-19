<?php

include "vendor/autoload.php";

use Anonym\Whois;
$whois = new Whois('kophack.com');
$whois->parseData();

echo $whois->printByJson();