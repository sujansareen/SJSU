#!/bin/bash
#
# MAC OS X: built using xcode. You may need to run 'xcode-select --install'

PY11_HOME=~/Developer/pybind11/pybind11-master

g++ -shared -std=c++11 -undefined dynamic_lookup -fPIC -O2 -I $PY11_HOME/include `cat py-args` example.c -o example.so

# to run
# python -c "import example; example.add(3,6)"
