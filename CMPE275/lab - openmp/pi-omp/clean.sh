#!/bin/bash
# 
# clean up cmake created files

find . -name cmake_install.cmake -exec rm {} \;
find . -name CMakeCache.txt -exec rm {} \;
find . -name Makefile -exec rm {} \;
find . -name CMakeFiles -exec rm -r {} \;

# exes

rm src/pi3
rm src/pi3b

