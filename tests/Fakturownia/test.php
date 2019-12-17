<?php

require_once __DIR__.'/../../vendor/autoload.php';

use PiSystems\Fakturownia\Fakturownia;

if(class_exists(Fakturownia::class)) {
    echo "OK";
} else {
    echo "ERROR";
}