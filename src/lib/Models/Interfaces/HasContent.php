<?php

namespace Takuya\BacklogApiClient\Models\Interfaces;

interface HasContent {
  public function getContent():string;
}