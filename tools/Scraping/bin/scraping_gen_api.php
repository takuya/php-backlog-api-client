<?php
require_once __DIR__.'/../libs/BacklogDocToClass.php';
require_once __DIR__.'/../libs/JsonPropCodeGen.php';
require_once __DIR__.'/../libs/helpers.php';

use Takuya\BacklogApiDocScraping\BacklogDocToClass;



function execute():int {
  BacklogDocToClass::execute();
  return 0;
}


execute();