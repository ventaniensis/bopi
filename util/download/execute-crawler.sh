#!/bin/bash
cd crawler
/Tools/phantomjs/bin/phantomjs --ignore-ssl-errors=yes  bopi-downloader.js $1 $2 $3
