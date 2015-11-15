#!/bin/bash

a=$1"-01-01"
b=$1"-12-31"
echo $a
echo $b

currentDateTs=$(date -j -f "%Y-%m-%d" $a "+%s")
endDateTs=$(date -j -f "%Y-%m-%d" $b "+%s")
offset=86400

while [ "$currentDateTs" -le "$endDateTs" ]
do
  date=$(date -j -f "%s" $currentDateTs "+%Y %m %d")
  echo $date
  ./execute-complete.sh $date
  currentDateTs=$(($currentDateTs+$offset))
done