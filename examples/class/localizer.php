<?php

use Nabeghe\LightLocalization\Localizer;

require_once __DIR__ . '/../../vendor/autoload.php';

$localizer = new Localizer(__DIR__ . '/langs');
var_dump($localizer->getTranslators());
echo $localizer->get('title');
echo PHP_EOL;
echo $localizer->get('message');
echo PHP_EOL;
echo $localizer->get('primary_btn_title') . '|' . $localizer->get('secondary_btn_title');
echo PHP_EOL;
echo $localizer->get('success');
echo PHP_EOL;
echo $localizer->get('unsuccess');