# Fingerprint

## What is it?

The fingerprint function takes in a path like `static/styles/all.css` and adds a fingerprint based on the file contents so it becomes like `static/styles/all.312aae3b4ab1590afcc4e15cb3962759.css`.

## Why use it?

As the fingerprint on the file changes after the contents of the file have been changed it will help you to bust the browsercache.

## How to use it?

Use it as a standalone function or wrap it in a class. Be sure to add the following code to your `.htacces` file in order to point the fingerprinted asset to the right file:

```APACHECONF
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.+)\.([0-9a-z]{32})\.(js|css|png|jpg|gif|svg|ico)$ $1.$3 [L]
```

And then you can use it in PHP as follows:

```PHP
echo css(fingerprint('static/styles/all.css'));
```

## Author
Iksi, <http://www.iksi.cc/>
