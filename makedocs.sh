#!/bin/bash

rm -rf _docs
rm -rf docs
mkdir _docs
mkdir docs
php phpDocumentor.phar -d src/ -t _docs --template="xml"
vendor/bin/phpdocmd _docs/structure.xml docs
rm -rf _docs
