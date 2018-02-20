#!/usr/bin/env bash

phpdbg -qrr -d memory_limit=-1 ./bin/phpunit --coverage-html=build


