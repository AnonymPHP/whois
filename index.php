<?php

include "vendor/autoload.php";

use Anonym\Whois;
$whois = new Whois('http://kophack.com');

var_dump($whois);