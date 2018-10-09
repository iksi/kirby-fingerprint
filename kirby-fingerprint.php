<?php

/**
 * Fingerprint css and js assets
 *
 * @version 1.5
 * @author Jurriaan Topper <jurriaan@iksi.eu> (http://www.iksi.eu/)
 * @license MIT
 */

if (c::get('plugin.fingerprint', false) === true) {
  load([
    'iksi\\component\\css' => __DIR__ . '/src/css.php',
    'iksi\\component\\js' => __DIR__ . '/src/js.php'
  ]);

  $kirby->set('component', 'css', 'Iksi\\Component\\CSS');
  $kirby->set('component', 'js', 'Iksi\\Component\\JS');
}
