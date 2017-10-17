#include "engine.hpp"

namespace Engine {

void Engine::Worker::fn(int h) {
   x = h;
}

void Engine::Worker::fn2(int h, int w) {
   x = h;
   x = w;
}

}

