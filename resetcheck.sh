#!/bin/sh
for f in "webroot/commandcheck"/*
do
    echo "Merubah $f"
    echo 0 > "$f"
done
