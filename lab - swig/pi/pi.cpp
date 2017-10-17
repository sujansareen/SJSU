
double calcPI(long num_steps) {

   double step = 1.0/(double) num_steps; 
   double pi = 0.0;
 
   double x = 0.0;
   double sum = 0.0;

   if ( num_steps > 0 )
   {
      int id = 0;
      for ( int i=id; i< num_steps; i++ ) { 
         x = (i+0.5)*step; 
         sum = sum + 4.0/(1.0+x*x); 
      } 
   }

   pi += step * sum; 

   return pi; 
} 
