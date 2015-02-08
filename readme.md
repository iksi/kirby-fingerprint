# Fingerprint

## What is it?

The fingerprint function takes a path like `static/styles/all.css` and adds a fingerprint based on the file contents so it becomes something like `static/styles/all.312aae3b4ab1590afcc4e15cb3962759.css`.

## Why use it?

As the fingerprint on the file changes after the contents of the file have been changed it will help you bust the browsercache.

## How to use it?

Put the `fingerprint` folder in `/site/plugins` and make sure you add the contents of the `.htaccess` to your `.htaccess` file in order to point the fingerprinted asset to the right file. Then you can use it in PHP as follows:

```PHP
echo css(fingerprint('static/styles/all.css'));
```

## Author
Iksi, <http://www.iksi.cc/>
