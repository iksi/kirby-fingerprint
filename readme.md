# Fingerprint

### Update

Added `cssfingerprint()` and `jsfingerprint()` as replacement functions for Kirby’s built-in `css` and `js` functions so it’s possible to use `@auto` for autoloading and fingerprinting template specific files. You can still use the `fingerprint` function as it was but it won’t work with `@auto`.

## What is it?

The `cssfingerprint()` and `jsfingerprint()` functions add fingerprints to the filenames based on contents of the files.

## Why use it?

As the fingerprint on the file changes after the contents of the file have been changed it will help you bust the browsercache.

## How to use it?

Put the `fingerprint` folder in `/site/plugins` and make sure you add the contents of the `.htaccess` to your `.htaccess` file in order to point the fingerprinted asset to the right file. Make sure you put the `.htaccess` rules  directly after `RewriteEngine on` before the other Kirby `.htaccess` rules. Then you can use it in PHP as follows:

```PHP
echo cssfingerprint('static/css/all.css'));
echo jsfingerprint('static/js/all.js'));
```

You can also use it with using Kirby’s `@auto`:

```PHP
echo cssfingerprint('@auto'));
echo jsfingerprint('@auto'));
```

### External urls

External urls won’t be fingerprinted.

## Author
Iksi, <http://www.iksi.cc/>
