/**
 * When we create libraries or decompose larger codes into classes/methods/routines we can 
 * create unexpected behavior. This code fragment is an oversimplification of what happens
 * when we have nested parallel blocks.
 *
 * Instead of for-loops, parallel regions are used for readability.
 */

#include <sstream>
#include "omp.h"

// enable/disable to see effects
//#define DO_NESTING 

/**
 * a function with parallel work. This could be a library 
 */
void doMoreWork(int tid, int tid2) {
	#pragma omp parallel
	{
		// id is not what you think!
		int tid3 = omp_get_thread_num();

		// this is what the code likely expected when threading line 45
		// thread 3/0/0
		// thread 1/0/0
		// thread 2/0/0
		// thread 0/0/0
		printf("thread %d/%d/%d\n",tid,tid2,tid3);
	}
}

/**
 * a function with parallel work. This could be a library 
 */
void doWork(int tid) {
    #pragma omp parallel
    {	
    	// id is not what you think!
    	int tid2 = omp_get_thread_num();
    	doMoreWork(tid,tid2);
    }
}

int main(int argc, char** argv) {

	// this is not creating the intended number of threads because of the 
	// nested parallel regions
	#pragma omp parallel 
	{
     	int tid = omp_get_thread_num();
                      
        #ifdef DO_NESTING
        // note this can be set at runtime!
        omp_set_nested(true);
        #endif

        // let's thread this work
        doWork(tid);
	}
}