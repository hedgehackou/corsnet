#!/bin/sh
set -e

echo "Deploying application ..."

cd back && make -f Makefile update && cd -;
cd front && make -f Makefile update && cd -;
:

echo "Application deployed!"