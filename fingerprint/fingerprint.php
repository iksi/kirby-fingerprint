<?php
/**
 * Fingerprint files
 *
 * @author Iksi <info@iksi.cc>
 * @version 1.2
 */
function fingerprint($path)
{
    if ( ! file_exists($path) || count($pathinfo = pathinfo($path)) < 4) {
        return $path;
    }

    $basename = $pathinfo['filename'] . '.' . md5_file($path)
        . '.' . $pathinfo['extension'];

    if ($pathinfo['dirname'] === '.') {
        return $filename;
    }

    return $pathinfo['dirname'] . DS . $basename;
}

function cssfingerprint($url, $media = null)
{
    if (is_array($url)) {
        $css = array();
        foreach ($url as $u) {
            $css[] = cssfingerprint($u);
        }
        return implode(PHP_EOL, $css) . PHP_EOL;
    }

    // auto template css files
    if ($url == '@auto') {
        $kirby = kirby::instance();
        $file  = $kirby->site()->page()->template() . '.css';
        $root  = $kirby->roots()->autocss() . DS . $file;
        $url   = preg_replace(
            '#^' . $kirby->urls()->index() . '/#', '',
            $kirby->urls()->autocss() . '/' . $file
        );

        if ( ! file_exists($root)) {
            return false;
        }
    }

    return html::tag('link', null, array(
        'rel'   => 'stylesheet',
        'href'  => url(fingerprint($url)),
        'media' => $media
    ));
}

function jsfingerprint($src, $async = false)
{
    if (is_array($src)) {
        $js = array();
        foreach($src as $s) {
            $js[] = jsfingerprint($s);
        }
        return implode(PHP_EOL, $js) . PHP_EOL;
    }

    // auto template css files
    if ($src == '@auto') {
        $kirby = kirby::instance();
        $file  = $kirby->site()->page()->template() . '.js';
        $root  = $kirby->roots()->autojs() . DS . $file;
        $src   = preg_replace(
            '#^' . $kirby->urls()->index() . '/#', '',
            $kirby->urls()->autojs() . '/' . $file
        );

        if ( ! file_exists($root)) {
            return false;
        }
    }

    return html::tag('script', '', array(
        'src'   => url(fingerprint($src)),
        'async' => $async
    ));
}
