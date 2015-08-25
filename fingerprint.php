<?php

/**
 * Fingerprint css and js assets
 *
 * @version 1.3
 * @author Iksi <info@iksi.cc>
 */

if ( ! c::get('fingerprint')) return;

$kirby      = kirby::instance();
$cssHandler = $kirby->option('css.handler');
$jsHandler  = $kirby->option('js.handler');

$kirby->options['css.handler'] = function($url, $media = null) use($cssHandler, $kirby) {

    if (is_array($url)) {
        $css = array();
        foreach ($url as $u) $css[] = call($kirby->option('css.handler'), $u);
        return implode(PHP_EOL, $css) . PHP_EOL;
    }

    if ($url === '@auto') {
        $file = $kirby->site()->page()->template() . '.css';
        $root = $kirby->roots()->autocss() . DS . $file;
        $url  = $kirby->urls()->autocss() . '/' . $file;

        if ( ! file_exists($root)) return false;

        $url = preg_replace('#^' . $kirby->urls()->index() . '/#', null, $url);
    }

    if (file_exists($url)) {
        $modifier = md5_file($url);
        $filename = f::name($url) . '.' . $modifier . '.' . f::extension($url);
        $dirname  = f::dirname($url);

        $url = ($dirname === '.') ? $filename : $dirname . '/' . $filename;
    }

    return call($cssHandler, array($url, $media));
};

$kirby->options['js.handler'] = function($src, $async = false) use($jsHandler, $kirby) {

    if (is_array($src)) {
        $js = array();
        foreach($src as $s) $js[] = call($kirby->options['js.handler'], $s);
        return implode(PHP_EOL, $js) . PHP_EOL;
    }

    if ($src === '@auto') {
        $file = $kirby->site()->page()->template() . '.js';
        $root = $kirby->roots()->autojs() . DS . $file;
        $src  = $kirby->urls()->autojs() . '/' . $file;

        if ( ! file_exists($root)) return false;

        $src = preg_replace('#^' . $kirby->urls()->index() . '/#', null, $src);
    }

    if (file_exists($src)) {
        $modifier = md5_file($src);
        $filename = f::name($src) . '.' . $modifier . '.' . f::extension($src);
        $dirname  = f::dirname($src);

        $src = ($dirname === '.') ? $filename : $dirname . '/' . $filename;
    }

    return call($jsHandler, array($src, $async));
};
