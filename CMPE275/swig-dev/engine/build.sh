#!/bin/bash

# create wrapper
/usr/local/swig/bin/swig -c++ -python engine.i

# compile
g++ -fPIC -c engine.cpp
g++ -O2 -fPIC -c engine_wrap.cxx -I/System/Library/Frameworks/Python.framework/Versions/2.7/include/python2.7

# build the shared object (library)
g++ -lpython -dynamiclib engine.o engine_wrap.o -o _engine.so
