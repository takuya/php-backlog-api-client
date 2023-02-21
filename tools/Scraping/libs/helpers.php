<?php

namespace Takuya\BacklogApiDocScraping;

function cache_path($file){
  $cache_dir = __DIR__.'/../../cache/';
  if ( !file_exists($cache_dir)){
    mkdir($cache_dir);
  }
  return $cache_dir.$file;
}

function resolve_path( $target ) {
  //cleanup
  $target = str_replace('//', '/', $target);
  $target = rtrim($target, '/');
  $names = explode('/', $target);
  function array_each_with_index( callable $callable, &$arr ) {
    return array_each($callable, $arr, range(0, count($arr) - 1));
  }
  
  function array_each( callable $callable, &$arr ) {
    array_walk($arr, $callable);
    
    return $arr;
  }
  
  array_each_with_index(function ( $e, $i ) use ( &$names ) {
    if( $e == '.' ) {
      unset($names[$i]);
    }
    if( $e == '..' ) {
      unset($names[$i - 1]);
      unset($names[$i]);
    }
  }, $names);
  
  return implode('/', $names);
}

if( ! function_exists('unparse_url') ) {
  function unparse_url( array $parsed ):string {
    $pass = $parsed['pass'] ?? null;
    $user = $parsed['user'] ?? null;
    $userinfo = $pass !== null ? "$user:$pass" : $user;
    $port = $parsed['port'] ?? 0;
    $scheme = $parsed['scheme'] ?? "";
    $query = $parsed['query'] ?? "";
    $fragment = $parsed['fragment'] ?? "";
    $authority = ( ( $userinfo !== null ? "$userinfo@" : "" ).( $parsed['host'] ?? "" ).( $port ? ":$port" : "" ) );
    
    return ( ( \strlen($scheme) > 0 ? "$scheme:" : "" ).( \strlen($authority) > 0 ? "//$authority" : "" )
             .( $parsed['path'] ?? "" ).( \strlen($query) > 0 ? "?$query" : "" ).( \strlen($fragment) > 0 ?
        "#$fragment" : "" ) );
  }
}
function url_join( $base_url, $href ) {
  $base = parse_url($base_url);
  $href = parse_url($href);
  $u = $base;
  if( preg_match('|^/|i', $href['path']) ) {
    $u['path'] = $href['path'];
  } else {
    $u['path'] = resolve_path(sprintf('%s/%s', $base['path'], $href['path']));
  }
  
  return unparse_url($u);
}

function kababToCamel($input)
{
  return lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $input))));
}


