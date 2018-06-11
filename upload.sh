#!/bin/sh
echo Upload to server, pick one
echo 1. Folder /src
echo 2. Folder /webroot/commandcheck
echo 3. Folder /webroot/css
echo 4. Folder /webroot/js
echo 5. composer.json
echo 6. Folder /vendor
echo 7. All above
echo Enter your number:
#read no
scp -r src aan@139.99.98.147:/var/www/html/automateit
scp -r webroot/commandcheck aan@139.99.98.147:/var/www/html/automateit/webroot
scp -r webroot/css aan@139.99.98.147:/var/www/html/automateit/webroot
scp -r webroot/js aan@139.99.98.147:/var/www/html/automateit/webroot
scp composer.json aan@139.99.98.147:/var/www/html/automateit

#scp -r src aan@139.99.98.147:/var/www/html/automateit
#scp -r webroot/commandcheck aan@139.99.98.147:/var/www/html/automateit/webroot
#scp -r webroot/css aan@139.99.98.147:/var/www/html/automateit/webroot
#scp -r webroot/js aan@139.99.98.147:/var/www/html/automateit/webroot
#scp composer.json aan@139.99.98.147:/var/www/html/automateit
#scp -r vendor aan@139.99.98.147:/var/www/html/automateit
