#include <iostream>
#include <boost/chrono.hpp>

/**
 * @brief basic boost chrono
 *
 * To build:
 * g++ -I /usr/local/gcc/boost_1_60_0/include -L /usr/local/gcc/boost_1_60_0/lib -lboost_chrono -lboost_system -std=c++14 chrono-ex.cpp -o chrono-ex
 *
 *      Author: gash
 */
int main(int argc, char **argv) {

    using namespace boost::chrono;
    auto dt_s = high_resolution_clock::now();

    #pragma omp parallel
    {
#if defined(_OPENMP)
        int ID = omp_get_thread_num();
#else
        int ID = 0;
#endif
        std::cerr << "Hello (" << ID << ") " << std::endl;
    }

    // or miliseconds
    auto dt = duration_cast<nanoseconds> (high_resolution_clock::now() - dt_s);

   std::cout << "dt = " << dt.count() << " ns" << "\n";
}
