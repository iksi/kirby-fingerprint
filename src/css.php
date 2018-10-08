<?php

namespace Iksi\Component;

use c;
use f;
use HTML;

class CSS extends \Kirby\Component\CSS {

  /**
   * Builds the html link tag for the given css file
   *
   * @param string $url
   * @param null|string $media
   * @return string
   */

  public function tag($url, $media = null) {

    if(is_array($url)) {
      $css = array();
      foreach($url as $u) $css[] = $this->tag($u, $media);
      return implode(PHP_EOL, $css) . PHP_EOL;
    }

    // auto template css files
    if($url == '@auto') {

      $file = $this->kirby->site()->page()->template() . '.css';
      $root = $this->kirby->roots()->autocss() . DS . $file;
      $url  = $this->kirby->urls()->autocss() . '/' . $file;

      if(!file_exists($root)) return false;

      $url = preg_replace('#^' . $this->kirby->urls()->index() . '/#', null, $url);

    }

    $url = ltrim($url, '/');

    if (file_exists($url)) {
      $hash = hash_file(c::get('plugin.fingerprint.algorithm', 'md5'), $url);
      $hash = substr($hash, 0, c::get('plugin.fingerprint.trim', 20));
      $filename = f::name($url) . '-' . $hash . '.' . f::extension($url);
      $dirname  = f::dirname($url);

      $url = ($dirname === '.') ? $filename : $dirname . '/' . $filename;
    }

    // build the array of HTML attributes
    $attr = array(
      'rel'  => 'stylesheet',
      'href' => url($url)
    );
    if(is_array($media)) {
      $attr = array_merge($attr, $media);
    } else if(is_string($media)) {
      $attr['media'] = $media;
    }

    return html::tag('link', null, $attr);

  }
}
