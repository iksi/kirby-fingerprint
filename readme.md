# Fingerprint

## What is it?

The fingerprint function takes a path like `static/styles/all.css` and adds a fingerprint based on the file contents so it becomes something like `static/styles/all.312aae3b4ab1590afcc4e15cb3962759.css`.

## Why use it?

As the fingerprint on the file changes after the contents of the file have been changed it will help you to bust the browsercache.

## How to use it?

Make sure you add the contents of `htaccess.txt` to your `.htacces` file in order to point the fingerprinted asset to the right file.

And then you can use it in PHP as follows:

```PHP
echo css(fingerprint('static/styles/all.css'));
```

## Author
Iksi, <http://www.iksi.cc/>
