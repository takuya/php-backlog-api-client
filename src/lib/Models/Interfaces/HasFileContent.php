<?php

namespace Takuya\BacklogApiClient\Models\Interfaces;

interface HasFileContent {
  public function getContent():string;
}