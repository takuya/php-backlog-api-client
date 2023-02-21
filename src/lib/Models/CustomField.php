<?php

namespace Takuya\BacklogApiClient\Models;

class CustomField extends BaseModel {
  
  public const TYPE_STRING        = 1;
  public const TYPE_TEXT          = 2;
  public const TYPE_NUMBER        = 3;
  public const TYPE_DATE          = 4;
  public const TYPE_SELECT_SINGLE = 5;
  public const TYPE_SELECT_MULTI  = 6;
  public const TYPE_CHECKBOX      = 7;
  public const TYPE_RADIO_BUTTON  = 8;
  public int    $typeId;
  public int    $version;
  public string $name;
  public string $description;
  public bool   $required;
  public bool   $useIssueType;
  public array  $applicableIssueTypes;
  public int    $displayOrder;
  public ?bool  $allowAddItem;
  public array  $items;
}