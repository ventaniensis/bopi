#!/bin/bash
# yyyy mm dd
./execute-crawler.sh $1 $2 $3
php index.php $1 $2 $3
rm cache.bopi/$1$2$3*.gz
cd examples
php remove-images.php $1 $2 $3
