#
# Note this will work (likely) for linux but not mac os x
#

cmake_minimum_required(VERSION 3.3)

set(SWIG_EXECUTABLE "/usr/local/swig/bin/swig")
find_package(SWIG REQUIRED)
include(${SWIG_USE_FILE})

find_package( PythonLibs 2.7 REQUIRED )
find_package( PythonInterp 2.7 REQUIRED )
#find_package(PythonLibs)
include_directories(${PYTHON_INCLUDE_PATH})
#include_directories(/System/Library/Frameworks/Python.framework/Versions/2.7/include/python2.7)


# there is a problem in gcc/g++ building on mac os x s.t. the reliance on 
# xcode libraries/headers creates a problem finding certain libraries/includes.

#include(FindOpenMP)
#if(OPENMP_FOUND)
#set(CMAKE_C_FLAGS "${CMAKE_C_FLAGS} ${OpenMP_C_FLAGS}")
#set(CMAKE_CXX_FLAGS "${CMAKE_CXX_FLAGS} ${OpenMP_CXX_FLAGS}")
#set(CMAKE_EXE_LINKER_FLAGS "${CMAKE_EXE_LINKER_FLAGS} ${OpenMP_EXE_LINKER_FLAGS}")
#else(OPENMP_FOUND)
#  message("\n\n** openmp not found! **\n\n")
#  return()
#endif(OPENMP_FOUND)

include_directories(${CMAKE_CURRENT_SOURCE_DIR})

set(CMAKE_SWIG_FLAGS "")

set_source_files_properties(mathish.i properties CPLUSPLUS ON)
set_source_files_properties(mathish.i properties SWIG_FLAGS "-includeall")

SWIG_ADD_MODULE(mathish python mathish.i pi.cpp)
SWIG_LINK_LIBRARIES(mathish ${PYTHON_LIBRARIES})

