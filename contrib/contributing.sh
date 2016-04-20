#!/bin/sh

echo "###Tidyng up the code ###"

./bin/phpcs -p --standard=PSR2 --warning-severity=6 --colors src/ && \
./bin/phpcbf -p --standard=PSR2 --warning-severity=6 src/
if [ $? != 0 ]
	then
		echo "There are some code style issue. Fix them before submitting your code."
		exit 1
	fi

echo "### DONE! ###"
