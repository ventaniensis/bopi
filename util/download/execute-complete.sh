#!/bin/bash

./execute-crawler.sh $1 $2 $3
./download_daily.sh $1 $2 $3
exit;
RESULT=`./download_daily.sh $1 $2 $3 | grep "Result" | sed s/Result// | sed s/://`
if [ $RESULT == "ok" ]
  then
  	echo "OK"
  else
	RESULT=`./execute-crawler.sh $1 $2 $3`
	if [ $RESULT != "EMPTY" ]
	  then
	    sleep 1
		./download_daily.sh $1 $2 $3
		echo $RESULT
	  else
	  	echo "NOT FOUND"
	fi
fi


