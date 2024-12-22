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
<nav id="menu" class="navbar navbar-default navbar-fixed-top on">
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
        <li><a href="{{ url('/') }}#page-top" class="page-scroll">Home</a></li>
        <li><a href="{{ url('/') }}#about" class="page-scroll">About</a></li>
        <li><a href="{{ url('/') }}#portfolio" class="page-scroll">Gallery</a></li>
        <li><a href="{{ url('/') }}#find-us" class="page-scroll">Contact</a></li>
        <li><a href="{{ url('mybill') }}" class="page-scroll">Payment</a></li>
      </ul>
    </div>
    <!-- /.navbar-collapse --> 
  </div>
  <!-- /.container-fluid --> 
</nav>
<div id="contact" class="text-center">
  <div class="container py-5"> 
<iframe 
  id="adaptive-iframe"
  src="{{ url('/payment') }}" 
  style="border: none; width: 100%; height: 1300px;" 
  title="Payment Page">
</iframe>

</div>
</div>

<div id="footer">
  <div class="container text-center">
    <div class="fnav">
      <p>Copyright &copy; 2024 Bali Heppi.</p>
    </div>
  </div>
</div>
<!-- JavaScript Files -->
 <!-- Load jQuery first -->
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

 <!-- Load Bootstrap (if needed) -->
 <script src="{{ asset('public/js/bootstrap.js') }}"></script>

 <!-- Load Inputmask -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.7/inputmask.min.js"></script>

 <!-- Load SmoothScroll from CDN -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scroll/16.1.3/smooth-scroll.min.js"></script>

 <!-- Load Other Scripts -->
 <script src="{{ asset('public/js/nivo-lightbox.js') }}"></script>
 <script src="{{ asset('public/js/jquery.isotope.js') }}"></script>
 <script src="{{ asset('public/js/jqBootstrapValidation.js') }}"></script>
 <script src="{{ asset('public/js/contact_me.js') }}"></script>
 {{-- <script src="{{ asset('public/js/main.js') }}"></script> --}}

<script id="midtrans-script" type="text/javascript"
src="https://api.midtrans.com/v2/assets/js/midtrans-new-3ds.min.js"
data-environment="sandbox"
data-client-key="SB-Mid-client-y44CMrM32XNm4ZA0"></script>
{{-- @section('scripts') --}}
  <script>

      // const iframe = document.getElementById('adaptive-iframe');

      // iframe.onload = function () {
      //   // Adjust iframe height based on its content
      //   iframe.style.height = iframe.contentWindow.document.body.scrollHeight + 'px';
      // };

      // // Optional: Listen for changes in iframe content to adjust height dynamically
      // window.addEventListener('message', function (event) {
      //   if (event.origin === "{{ url('/') }}") {
      //     const newHeight = event.data.height;
      //     iframe.style.height = newHeight + 'px';
      //   }
      // });

    
  </script>

</body>
</html>