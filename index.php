<?php

include "vendor/autoload.php";

use Anonym\Whois;
$whois = new Whois('kophack.com');

print_r($whois->parseData());