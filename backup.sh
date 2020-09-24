#!/bin/bash

cd storage/app/Taskord/
git pull origin master
git add -A
git commit -am "Backup"
git push origin master
