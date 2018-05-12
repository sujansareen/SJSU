@extends('layouts.app')
@section('content')
    <main role="main">
      <div id="myCarousel" class="carouvsel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item">
            <img class="first-slide" src="http://weiyangpan272.net/wp-content/uploads/2018/03/cropped-maxresdefault.jpg" alt="First slide">
            <div class="container">
              <div class="carousel-caption text-left">
                <h1 style="color:black;">PaperClipper</h1>
                <p style="color:black;">PaperClipper is a company that provides proofreading services for your translation text.</p>
                <p><a class="btn btn-lg btn-primary" href="http://weiyangpan272.net" role="button">Sign up today</a></p>
              </div>
            </div>
          </div>
          <div class="carousel-item active">
            <img class="second-slide" src="http://students.engr.scu.edu/~kta/StoryMode/images/desk.jpg" alt="Second slide">
            <div class="container">
              <div class="carousel-caption">
                <h1>Story Mode</h1>
                <p>At Story Mode, we work with storytellers in finding the best medium for their work, including:

Graphic Novels
Gameplay Experiences
3D and 2D Animation</p>
                <p><a class="btn btn-lg btn-primary" href="http://students.engr.scu.edu/~kta/StoryMode/index.html" role="button">Browse gallery</a></p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="third-slide" src="http://fulbertj.com/images/demo/backgrounds/01.png" alt="Third slide">
            <div class="container">
              <div class="carousel-caption text-right">
                <h1>EMBEDDED SYSTEM SOLUTION (ESS)</h1>
                <p>We are a team of experienced Embedded System Designer who deliver high quality products since 2018.</p>
                <p><a class="btn btn-lg btn-primary" href="http://fulbertj.com/" role="button">Learn More</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>

        <br>
      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->

      <div class="container marketing">

        <!-- Three columns of text below the carousel -->
        <div class="row">
          <div class="col-lg-4">
            <img class="rounded-circle" src="http://mymemories.arturomontoya.me/images/products/grenada.png" alt="Generic placeholder image" width="140" height="140">
            <h2>Grenada</h2>
            <p>Grenada, known as Spice Island, remains one of the Caribbean's under-the-radar gems, even though it's got what every traveler wants: uncrowded beaches, preserved rain forests, and a lively local culture and cuisine.</p>
            <p><a class="btn btn-secondary" href="http://mymemories.arturomontoya.me/products/3" role="button">View details »</a></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded-circle" src="http://sujansareen.com/wp-content/uploads/2018/03/book5-197x300.jpg" alt="Generic placeholder image" width="140" height="140">
            <h2>IT</h2>
            <p>IT is a 1986 horror novel by American author Stephen King. The story follows the experiences of seven children as they are terrorized by an entity that exploits the fears and phobias of its victims to disguise itself while hunting its prey.</p>
            <p><a class="btn btn-secondary" href="http://mymemories.arturomontoya.me/products/39" role="button">View details »</a></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded-circle" src="http://mymemories.arturomontoya.me/images/products/losCabos-mexico.png" alt="Generic placeholder image" width="140" height="140">
            <h2>Los Cabos, Mexico</h2>
            <p>Located at the tip of the Baja Peninsula, the two small colonial towns of Cabo San Lucas and San Jose del Cabo have become the hottest vacation destinations in Mexico in recent years.</p>
            <p><a class="btn btn-secondary" href="http://mymemories.arturomontoya.me/products/5" role="button">View details »</a></p>
          </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->


        <!-- START THE FEATURETTES -->

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">Mostly reviewed: <span class="text-muted">Walla Walla Valley, Washington.</span></h2>
            <p class="lead">With more than 300 days of sunshine each year, the southeastern corner of Washington state is home to three flourishing viticultural regions: the Columbia, Walla Walla, and Yakima Valleys.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="500x500" style="width: 500px; height: 300px; position: relative; top: 60px;" src="http://mymemories.arturomontoya.me/images/products/wallaWallaValley-washington.png" data-holder-rendered="true">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">Bestly Rated: <span class="text-muted">Fiji</span></h2>
            <p class="lead">It's no secret that Fiji is home to some of the world's most spectacular scenery - powdery beaches fringed with palms, crystalline waters with colorful reefs, and rugged coastlines covered in greenery.</p>
          </div>
          <div class="col-md-5 order-md-1">
            <img class="featurette-image img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="500x500" src="http://mymemories.arturomontoya.me/images/products/fiji.png" data-holder-rendered="true" style="width: 500px; height: 300px; position: relative; top: 60px;">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">Trending Right now: <span class="text-muted">The Davinci Code</span></h2>
            <p class="lead">The Da Vinci Code is a 2003 mystery thriller novel by Dan Brown. It follows "symbologist" Robert Langdon and cryptologist Sophie Neveu after a murder in the Louvre Museum in Paris causes them to become involved in a battle between the Priory of Sion and Opus Dei over the possibility of Jesus Christ having been a companion to Mary Magdalene.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="500x500" src="http://sujansareen.com/wp-content/uploads/2018/03/book9-198x300.jpg" data-holder-rendered="true" style="width: 500px; height: 650px;">
          </div>
        </div>

        <hr class="featurette-divider">

        <!-- /END THE FEATURETTES -->

      </div><!-- /.container -->


      <!-- FOOTER -->
      <footer class="container">
        <p class="float-right"><a href="/">Back to top</a></p>
        <p>© 2017-2018 Company, Inc. · <a href="/">Privacy</a> · <a href="/">Terms</a></p>
      </footer>
    </main>

@endsection
@section('header')
    @component('components.header')
    @endcomponent
@endsection



