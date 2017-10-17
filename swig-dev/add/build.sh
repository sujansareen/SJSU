#!/bin/bash

# create wrapper
/usr/local/swig/bin/swig -c++ -python example.i

# compile
g++ -fPIC -c example.c
g++ -O2 -fPIC -c example_wrap.cxx -I/System/Library/Frameworks/Python.framework/Versions/2.7/include/python2.7

# build the shared object (library)
g++ -lpython -dynamiclib example.o example_wrap.o -o _example.so
