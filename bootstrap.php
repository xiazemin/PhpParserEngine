<?php
require __DIR__ . '/vendor/autoload.php';
use Execute\Application;
$sDir=__DIR__."/exp/demo/";
$sClass="\\Demo\\ClassA\\ClassA1";
Application::Parse($sDir,$sClass);

