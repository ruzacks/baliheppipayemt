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
<link rel="shortcut icon" href="{{ asset('public/img/fav.png') }}" type="image/png">

<!-- Bootstrap -->
<link rel="stylesheet" href="{{ asset('public/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('public/fonts/font-awesome/css/font-awesome.css') }}">

<!-- Stylesheets -->
<link rel="stylesheet" href="{{ asset('public/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/nivo-lightbox/nivo-lightbox.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/nivo-lightbox/default.css') }}">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300" rel="stylesheet">

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
                ['category' => 'web', 'largeImg' => 'gallery_2.jpg', 'smallImg' => 'gallery_2.jpg', 'title' => 'Project Title'],
                ['category' => 'web', 'largeImg' => 'gallery_3.jpg', 'smallImg' => 'gallery_3.jpg', 'title' => 'Project Title'],
                ['category' => 'web', 'largeImg' => 'gallery_4.jpg', 'smallImg' => 'gallery_4.jpg', 'title' => 'Project Title'],
                ['category' => 'web', 'largeImg' => 'gallery_5.jpg', 'smallImg' => 'gallery_5.jpg', 'title' => 'Project Title'],
                ['category' => 'web', 'largeImg' => 'gallery_6.jpg', 'smallImg' => 'gallery_6.jpg', 'title' => 'Project Title'],
                ['category' => 'web', 'largeImg' => 'gallery_7.jpg', 'smallImg' => 'gallery_7.jpg', 'title' => 'Project Title'],
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
<!-- Contact Section -->
<div id="footer">
  <div class="container text-center">
    <div class="fnav">
      <p>Jl. Pulau Batam No.32, pesiapan, Kec. Tabanan, Kabupaten Tabanan, Bali 82114. Telp: 0858-5710-8560. 13.00 - 03.00</p>
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

<script id="midtrans-script" type="text/javascript"
src="https://api.midtrans.com/v2/assets/js/midtrans-new-3ds.min.js"
data-environment="sandbox"
data-client-key="SB-Mid-client-y44CMrM32XNm4ZA0"></script>
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
      
    function toggleCardDetails(show) {
      const cardDetails = document.getElementById('card-details');
      if (show) {
        cardDetails.classList.remove('hidden');
      } else {
        cardDetails.classList.add('hidden');
      }
    }

    // card data from customer input, for example
    var cardData = {
      "card_number": 4811111111111114,
      "card_exp_month": 02,
      "card_exp_year": 2025,
      // "card_cvv": 123,
      "OTP/3DS": 112233,
      "bank_one_time_token": "12345678"
    };

    // callback functions
    var options = {
      onSuccess: function(response){
        // Success to get card token_id, implement as you wish here
        console.log('Success to get card token_id, response:', response);
        var token_id = response.token_id;

        console.log('This is the card token_id:', token_id);
        // Implement sending the token_id to backend to proceed to next step
      },
      onFailure: function(response){
        // Fail to get card token_id, implement as you wish here
        console.log('Fail to get card token_id, response:', response);

        // you may want to implement displaying failure message to customer.
        // Also record the error message to your log, so you can review
        // what causing failure on this transaction.
      }
    };

    // trigger `getCardToken` function
    MidtransNew3ds.getCardToken(cardData, options);
  </script>

</body>
</html>