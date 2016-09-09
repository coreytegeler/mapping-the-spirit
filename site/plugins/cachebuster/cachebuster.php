<?php 

if(!c::get('cachebuster')) return;

$kirby      = kirby();
$cssHandler = kirby()->option('css.handler');
$jsHandler  = kirby()->option('js.handler');

$kirby->options['css.handler'] = function($url, $media = false) use($cssHandler, $kirby) {

  if(is_array($url)) {
    $css = array();
    foreach($url as $u) $css[] = call($kirby->options['css.handler'], $u);
    return implode(PHP_EOL, $css) . PHP_EOL;
  }

  $file = $kirby->roots()->index() . DS . $url;

  if(file_exists($file)) {
    $mod = f::modified($file);
    $url = dirname($url) . '/' . f::name($url) . '.' . $mod . '.css';
  }

  return call($cssHandler, array($url, $media));

};

$kirby->options['js.handler'] = function($src, $async = false) use($jsHandler, $kirby) {

  if(is_array($src)) {
    $js = array();
    foreach($src as $s) $js[] = call($kirby->options['js.handler'], $s);
    return implode(PHP_EOL, $js) . PHP_EOL;
  }

  $file = $kirby->roots()->index() . DS . $src;

  if(file_exists($file)) {
    $mod = f::modified($file);
    $src = dirname($src) . '/' . f::name($src) . '.' . $mod . '.js';
  }

  return call($jsHandler, array($src, $async));

};