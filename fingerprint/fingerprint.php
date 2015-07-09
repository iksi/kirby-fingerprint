<?php

/**
 * Fingerprint css and js assets
 *
 * @version 1.3
 * @author Iksi <info@iksi.cc>
 */

namespace iksi;

if ( ! \c::get('fingerprint')) return;

function fingerprint($url) {

    $info = pathinfo($url);

    if ( ! file_exists($url) or count($info) < 4) {
        return $url;
    }

    $path = $info['filename'] . '.' . md5_file($url) . '.' . $info['extension'];

    if ($info['dirname'] !== '.') {
        $path = $info['dirname'] . '/' . $path;
    }

    return $path;
}

$kirby      = \kirby::instance();
$cssHandler = $kirby->option('css.handler');
$jsHandler  = $kirby->option('js.handler');

$kirby->options['css.handler'] = function($url, $media = null) use($cssHandler, $kirby) {

    if (is_array($url)) {
        $css = array();
        foreach ($url as $u) $css[] = call($kirby->option('css.handler'), $u);
        return implode(PHP_EOL, $css) . PHP_EOL;
    }

    // auto template css files
    if ($url == '@auto') {
        $url = preg_replace('#^' . $kirby->urls()->index() . '/#', null,
            $kirby->urls()->autocss() . '/' . $kirby->site()->page()->template() . '.css');
    }

    return call($cssHandler, array(fingerprint($url), $media));
};

$kirby->options['js.handler'] = function($src, $async = false) use($jsHandler, $kirby) {

    if (is_array($src)) {
        $js = array();
        foreach($src as $s) $js[] = call($kirby->options['js.handler'], $s);
        return implode(PHP_EOL, $js) . PHP_EOL;
    }

    // auto template css files
    if ($src == '@auto') {
        $src = preg_replace('#^' . $kirby->urls()->index() . '/#', null,
            $kirby->urls()->autojs() . '/' . $kirby->site()->page()->template() . '.js');
    }

    return call($jsHandler, array(fingerprint($src), $async));
};
