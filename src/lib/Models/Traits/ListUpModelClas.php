<?php

namespace Takuya\BacklogApiClient\Models\Traits;

trait ListUpModelClas {
  public static function listModelClass():array{
  
    $ref = new \ReflectionClass(self::class);
    $dir = dirname($ref->getFileName());
    $list = array_merge(glob($dir.'/*.php'),glob($dir.'/**/*.php'));
    $list = array_map(fn($e)=>str_replace($dir.DIRECTORY_SEPARATOR,'',$e),$list);
    $list = array_filter($list,fn($e)=>!str_contains(strtolower($e),'traits'));
    $list = array_filter($list,fn($e)=>!str_contains(basename($e),basename($ref->getFileName())));
    $list = array_map(fn($e)=>str_replace('.php','',$e),$list);
    $list = array_map(fn($e)=>str_replace('/','\\',$e),$list);
    $list = array_map(fn($e)=>$ref->getNamespaceName().'\\'.$e,$list);
    $list = array_filter($list,fn($e)=>!(new \ReflectionClass($e))->isAbstract());
    $list = array_values($list);
    return $list;
  }
  
}