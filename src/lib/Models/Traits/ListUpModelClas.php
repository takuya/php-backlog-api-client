<?php

namespace Takuya\BacklogApiClient\Models\Traits;

trait ListUpModelClas {
  public static function listModelClass():array{
    
    $list = array_merge(glob(__DIR__.'/*.php'),glob(__DIR__.'/**/*.php'));
    $list = array_map(fn($e)=>str_replace(__DIR__.DIRECTORY_SEPARATOR,'',$e),$list);
    $list = array_filter($list,fn($e)=>!str_contains(strtolower($e),'traits'));
    $list = array_filter($list,fn($e)=>!str_contains(basename($e),basename(__FILE__)));
    $list = array_map(fn($e)=>str_replace('.php','',$e),$list);
    $list = array_map(fn($e)=>str_replace('/','\\',$e),$list);
    $list = array_map(fn($e)=>__NAMESPACE__.'\\'.$e,$list);
    return $list;
  }
  
}