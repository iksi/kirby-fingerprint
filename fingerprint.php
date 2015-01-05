<?php
/**
 * Fingerprint assets
 *
 * @author Iksi <info@iksi.cc>
 * @version 1.0.0
 */
function fingerprint($path)
{
    if ( ! file_exists($path))
    {
        return $path;
    }

    $filename  = pathinfo($path, PATHINFO_FILENAME)
        . '.' . md5_file($path) . '.'
        . pathinfo($path, PATHINFO_EXTENSION);

    $dirname = pathinfo($path, PATHINFO_DIRNAME);

    if ($dirname === '.')
    {
        return $filename;
    }

    return $dirname.DIRECTORY_SEPARATOR.$filename;
}
