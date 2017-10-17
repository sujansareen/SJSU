#pragma once

namespace Engine {

/**
 * @brief class setup
 */
class Worker {
   public: 
     Worker() : x(0), y(0) {}
     virtual ~Worker() {}

     void fn(int h);
     void fn2(int h,int w);

     int getX() const { return x; }
     int getY() const { return y; }

  private:  
 
     int x;
     int y;
};

} // module
