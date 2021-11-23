#!/bin/sh
set -e

echo "Deploying application ..."

git checkout master -f
git pull origin master
git fetch origin deploy
git checkout deploy
git reset --hard origin/deploy
git merge master -m "Merge"
git push origin deploy
cd back && make -f Makefile update && cd -;
cd front && make -f Makefile update && cd -;
:

echo "Application deployed!"