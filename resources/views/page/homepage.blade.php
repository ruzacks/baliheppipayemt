<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bali Heppi</title>
<meta name="description" content="">
<meta name="author" content="">

<!-- Favicons
    ================================================== -->
<!-- Favicon -->
<link rel="shortcut icon" href="{{ asset('public/img/favicon.ico') }}" type="image/png">

<!-- Bootstrap -->
<link rel="stylesheet" href="{{ asset('public/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('public/fonts/font-awesome/css/font-awesome.css') }}">

<!-- Stylesheets -->
<link rel="stylesheet" href="{{ asset('public/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/nivo-lightbox/nivo-lightbox.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/nivo-lightbox/default.css') }}">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<!-- Modernizr -->
<script src="{{ asset('public/js/modernizr.custom.js') }}" type="text/javascript"></script>


<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<!-- Navigation
    ==========================================-->
<nav id="menu" class="navbar navbar-default navbar-fixed-top">
  <div class="container"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand page-scroll" href="#page-top">
        <img src="{{ asset('public/img/logo.png') }}" alt="Bali Heppi" style="width: 100px; height: 100px; margin-top:-10px">
      </a>    
    </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#page-top" class="page-scroll">Home</a></li>
        <li><a href="#about" class="page-scroll">About</a></li>
        <li><a href="#portfolio" class="page-scroll">Gallery</a></li>
        <li><a href="#find-us" class="page-scroll">Contact</a></li>
        <li><a href="{{ url('mybill') }}" class="page-scroll">Payment</a></li>
      </ul>
    </div>
    <!-- /.navbar-collapse --> 
  </div>
  <!-- /.container-fluid --> 
</nav>
<!-- Header -->
<header id="header">
  <div class="intro">
    <div class="container">
      <div class="row">
        <div class="intro-text">
          <h1>Bali Heppi</h1>
          {{-- <a href="#about" class="btn btn-custom btn-lg page-scroll">Learn More</a> </div> --}}
      </div>
    </div>
  </div>
</header>
<!-- About Section -->
<div id="about">
  <div class="container">
    <div class="section-title text-center center">
      <h2>Bali Heppi</h2>
      <hr>
    </div>
    <div class="row">
      <div class="col-xs-12 col-md-6"> <img src="{{ asset('public/img/image 1.jpg') }}" class="img-responsive" alt=""> </div>
      <div class="col-xs-12 col-md-6">
        <div class="about-text">
          <p>One Stop Entertainment di Tabanan KTV,Bar & Lounge,DJ School,Rental Studio DJ,Rental Alat DJ,Rental SOUND & Lighting,Management DJ & Talent</p>
          <a href="#portfolio" class="btn btn-default btn-lg page-scroll">See Gallery</a> </div>
      </div>
    </div>
  </div>
</div>
<!-- Portfolio Section -->
<div id="portfolio">
  <div class="container">
    <div class="section-title text-center center">
      <h2 style="color: white">Gallery</h2>
      <hr>
    </div>
    <div class="categories">
      <ul class="cat">
        <li>
          <ol class="type">
            {{-- <li><a href="#" data-filter="*" class="active">All</a></li>
            <li><a href="#" data-filter=".web">Web Design</a></li>
            <li><a href="#" data-filter=".photography">Photography</a></li>
            <li><a href="#" data-filter=".product">Product Design</a></li> --}}
          </ol>
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="row">
      <div class="portfolio-items">
        @php
            $portfolioItems = [
                ['category' => 'web', 'largeImg' => 'gallery_2.jpg', 'smallImg' => 'gallery_2.jpg', 'title' => 'NBH Gallery'],
                ['category' => 'web', 'largeImg' => 'gallery_3.jpg', 'smallImg' => 'gallery_3.jpg', 'title' => 'NBH Gallery'],
                ['category' => 'web', 'largeImg' => 'gallery_4.jpg', 'smallImg' => 'gallery_4.jpg', 'title' => 'NBH Gallery'],
                ['category' => 'web', 'largeImg' => 'gallery_5.jpg', 'smallImg' => 'gallery_5.jpg', 'title' => 'NBH Gallery'],
                ['category' => 'web', 'largeImg' => 'gallery_6.jpg', 'smallImg' => 'gallery_6.jpg', 'title' => 'NBH Gallery'],
                ['category' => 'web', 'largeImg' => 'gallery_7.jpg', 'smallImg' => 'gallery_7.jpg', 'title' => 'NBH Gallery'],
            ];
        @endphp
    
        @foreach ($portfolioItems as $item)
            <div class="col-sm-6 col-md-3 col-lg-3 {{ $item['category'] }}">
                <div class="portfolio-item">
                    <div class="hover-bg">
                        <a href="{{ asset('public/img/portfolio/' . $item['largeImg']) }}" title="{{ $item['title'] }}" data-lightbox-gallery="gallery1">
                            <div class="hover-text">
                                <h4>{{ $item['title'] }}</h4>
                            </div>
                            <img src="{{ asset('public/img/portfolio/' . $item['smallImg']) }}" class="img-responsive" alt="{{ $item['title'] }}">
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    </div>
  </div>
</div>

<!-- About Section -->
<div id="find-us">
  <div class="container">
    <div class="section-title text-center center">
      <h2>Visit Our Location</h2>
      <hr>
    </div>
    <div class="row">
      <div class="col-xs-12 col-md-6">
        <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.731195030883!2d115.1122804!3d-8.5359148!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd23b3298e22307%3A0x83367017fc09b128!2sNew+Bali+Heppi!5e0!3m2!1sen!2sid!4v1619524992238!5m2!1sen!2sid" 
        width="100%" height="480" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
      </div>
      <div class="col-xs-12 col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Our Address</h5>
            <p class="card-text">Jl. Pulau Batam No.32, pesiapan, Kec. Tabanan, Kabupaten Tabanan, Bali 82114</p>
          </div>
          <div class="card-body border-top">
            <h5 class="card-title">Hours</h5>
            <p class="card-text">Sunday - Friday: 1.00 pm - 3.00 am</p>
            <p class="card-text">Saturday: 1.00 pm - 4.00 am</p>
          </div>
          <div class="card-body border-top">
            <h5 class="card-title">Contact</h5>
            <p class="card-text">Email: <a href="mailto:admin@nbh.my.id">admin@nbh.my.id</a></p>
            <p class="card-text">Phone: <a href="tel:+62085857108560">+62 858 5710 8560</a></p>
          </div>
          <div class="card-body border-top">
            <h5 class="card-title">Social Media</h5>
            <p class="card-text">
              <a href="https://www.instagram.com/newbaliheppikaraoke/?hl=en" target="_blank" style="text-decoration: none;">
                <i class="fab fa-instagram" style="color: #ebebeb; margin-right: 15px; font-size: 3rem;"></i>
              </a>
              <a href="https://chat.whatsapp.com/Giv9opLhrWRIVBRJPfksVy" target="_blank" style="text-decoration: none;">
                <i class="fab fa-whatsapp" style="color: #fefefe; margin-right: 15px; font-size: 3rem;"></i>
              </a>
              <a href="https://www.facebook.com/profile.php?id=61561441652696" target="_blank" style="text-decoration: none;">
                <i class="fab fa-facebook" style="color: #ffffff; margin-right: 15px; font-size: 3rem;"></i>
              </a>
              <a href="https://www.tiktok.com/@newbaliheppi" target="_blank" style="text-decoration: none;">
                <i class="fab fa-tiktok" style="color: #ffffff; font-size: 3rem;"></i>
              </a>
            </p>
          </div>
        </div>
    </div>
  </div>
</div>
</div>

<!-- Contact Section -->
<div id="footer">
  <div class="container text-center">
    <div class="fnav">
      <p>Copyright &copy; 2024 Bali Heppi.</p>
    </div>
  </div>
</div>
<!-- JavaScript Files -->
<script src="{{ asset('public/js/jquery.1.11.1.js') }}"></script>
<script src="{{ asset('public/js/bootstrap.js') }}"></script>
<script src="{{ asset('public/js/SmoothScroll.js') }}"></script>
<script src="{{ asset('public/js/nivo-lightbox.js') }}"></script>
<script src="{{ asset('public/js/jquery.isotope.js') }}"></script>
<script src="{{ asset('public/js/jqBootstrapValidation.js') }}"></script>
<script src="{{ asset('public/js/contact_me.js') }}"></script>
<script src="{{ asset('public/js/main.js') }}"></script>

{{-- @section('scripts') --}}
  <script>

  $(window).bind('scroll', function() {
          var navHeight = $(window).height() - 500;
          if ($(window).scrollTop() > navHeight) {
              $('.navbar-default').addClass('on');
          } else {
              $('.navbar-default').removeClass('on');
          }
      });
      
  </script>

</body>
</html>