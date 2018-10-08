<?php

namespace Iksi\Component;

use c;
use f;
use HTML;

class JS extends \Kirby\Component\JS {

  /**
   * Builds the html script tag for the given js file
   *
   * @param string $src
   * @param boolean async
   * @return string
   */

  public function tag($src, $async = false) {

    if(is_array($src)) {
      $js = array();
      foreach($src as $s) $js[] = $this->tag($s, $async);
      return implode(PHP_EOL, $js) . PHP_EOL;
    }

    // auto template js files
    if($src == '@auto') {

      $file = $this->kirby->site()->page()->template() . '.js';
      $root = $this->kirby->roots()->autojs() . DS . $file;
      $src  = $this->kirby->urls()->autojs() . '/' . $file;

      if(!file_exists($root)) return false;

      $src = preg_replace('#^' . $this->kirby->urls()->index() . '/#', null, $src);

    }

    $src = ltrim($src, '/');

    if (file_exists($src)) {
      $hash = hash_file(c::get('plugin.fingerprint.algorithm', 'md5'), $src);
      $hash = substr($hash, 0, c::get('plugin.fingerprint.trim', 20));
      $filename = f::name($src) . '-' . $hash . '.' . f::extension($src);
      $dirname  = f::dirname($src);

      $src = ($dirname === '.') ? $filename : $dirname . '/' . $filename;
    }

    // build the array of HTML attributes
    $attr = array('src' => url($src));
    if(is_array($async)) {
      $attr = array_merge($attr, $async);
    } else if($async === true) {
      $attr['async'] = true;
    }

    return html::tag('script', '', $attr);

  }
}
