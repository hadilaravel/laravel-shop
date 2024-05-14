<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>صفحه ارور 404 گمشده در فضا </title>
    <link type="text/css" href="{{ asset('page404/css/style.css') }}" rel="stylesheet" />
</head>
<body class="bg-purple">
<div class="stars">
    <!-- start logo and menu -->
    <!--		<div class="custom-navbar">-->
    <!--			<div class="brand-logo">-->
    <!--				<img src="pics/logo.svg" width="80px">-->
    <!--			</div>-->
    <!--			<div class="navbar-links">-->
    <!--				<ul>-->
    <!--					<li><a href="#" target="_blank">صفحه نخست</a></li>-->
    <!--					<li><a href="#" target="_blank">درباره ما</a></li>-->
    <!--				</ul>-->
    <!--			</div>-->f
    <!--		</div>-->
    <!-- end logo and menu -->
    <!-- start content -->
    <div class="central-body">
        <img class="image-404" src="{{ asset('page404/pics/404.png') }}" width="300px">
        <a href="{{ route('customer.home') }}" class="btn-go-home" >بازگشت</a>
    </div>
    <div class="objects">
        <img class="object_rocket" src="{{ asset('page404/pics/rocket.svg') }}" width="40px">
        <div class="earth-moon">
            <img class="object_earth" src="{{ asset('page404/pics/earth.svg') }}" width="100px">
            <img class="object_moon" src="{{ asset('page404/pics/moon.svg') }}" width="80px">
        </div>
        <div class="box_astronaut">
            <img class="object_astronaut" src="{{ asset('page404/pics/astronaut.svg') }}" width="140px">
        </div>
    </div>
    <div class="glowing_stars">
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
    </div>
    <!-- end content -->
</div>
<script src="{{ asset('page404/js/jquery-3.1.1.min.js') }}"></script>
</body><!-- This template has been downloaded from Webrubik.com -->
</html>
