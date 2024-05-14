@extends('customer.layouts.master-one-col')
@section('head-tag')
<title>فروشگاه آمازون</title>
@endsection
@section('content')

    @if(session('success'))
        <div class="alert-success alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('danger'))
        <div class="alert-danger alert">
            {{ session('danger') }}
        </div>
    @endif
        <!-- start slideshow -->
        <section class="container-xxl my-4">
            <section class="row">
                <section class="col-md-8 pe-md-1 ">
                    <section id="slideshow" class="owl-carousel owl-theme">
                        @foreach($slideShowImages as $slideShowImage)
                        <section class="item">
                            <a class="w-100 d-block h-auto text-decoration-none" target="_blank" href="{{ urldecode($slideShowImage->url) }}">
                                <img class="w-100 rounded-2 d-block h-auto" src="{{ asset($slideShowImage->image) }}" alt="{{ $slideShowImage->title }}">
                            </a>
                        </section>
                        @endforeach
                    </section>
                </section>
                <section class="col-md-4 ps-md-1 mt-2 mt-md-0">
                    @foreach($topBanners as $topBanner)
                    <section class="mb-2">
                        <a href="{{ urldecode($topBanner->url) }}" class="d-block" target="_blank">
                            <img class="w-100 rounded-2" src="{{ $topBanner->image }}" alt="{{ $topBanner->title }}">
                        </a>
                    </section>
                    @endforeach
                </section>
            </section>
        </section>
        <!-- end slideshow -->



        <!-- start product lazy load -->
        <section class="mb-3">
            <section class="container-xxl" >
                <section class="row">
                    <section class="col">
                        <section class="content-wrapper bg-white p-3 rounded-2">
                            <!-- start vontent header -->
                            <section class="content-header">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title">
                                        <span>پربازدیدترین کالاها</span>
                                    </h2>
                                    <section class="content-header-link">
                                        <a href="{{ route('customer.products' , ['sort' => 4]) }}">مشاهده همه</a>
                                    </section>
                                </section>
                            </section>
                            <!-- start vontent header -->
                            <section class="lazyload-wrapper" >
                                <section class="lazyload light-owl-nav owl-carousel owl-theme">
                                    @foreach($mostVisitedProducts as $mostVisitedProduct)
                                    <section class="item">
                                        <section class="lazyload-item-wrapper">
                                            <section class="product">
{{--                                                <section class="product-add-to-cart"><a href="#" data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به سبد خرید"><i class="fa fa-cart-plus"></i></a></section>--}}
                                                @guest
                                                    <section class="product-add-to-favorite">
                                                        <button data-url="{{ route('customer.market.add-to-favorite' , $mostVisitedProduct) }}" class=" btn btn-light btn-sm text-decoration-none"  data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به علاقه مندی">
                                                            <i class="fa fa-heart "></i>
                                                        </button>
                                                    </section>
                                                @endguest

                                                @auth
                                                    @if($mostVisitedProduct->user->contains(auth()->user()->id))
                                                        <section class="product-add-to-favorite">
                                                            <button data-url="{{ route('customer.market.add-to-favorite' , $mostVisitedProduct) }}" class=" btn btn-light btn-sm text-decoration-none"  data-bs-toggle="tooltip" data-bs-placement="left" title="حذف از علاقه مندی">
                                                                <i class="fa fa-heart text-danger"></i>
                                                            </button>
                                                        </section>
                                                    @else
                                                        <section class="product-add-to-favorite">
                                                            <button data-url="{{ route('customer.market.add-to-favorite' , $mostVisitedProduct) }}" class=" btn btn-light btn-sm text-decoration-none"  data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به علاقه مندی">
                                                                <i class="fa fa-heart "></i>
                                                            </button>
                                                        </section>
                                                    @endif
                                                @endauth

                                                <a class="product-link" href="{{ route('customer.market.product' , $mostVisitedProduct) }}">
                                                    <section class="product-image">
                                                        <img class="" src="{{ $mostVisitedProduct->image}}" alt="{{ $mostVisitedProduct->name }}">
                                                    </section>
                                                    <section class="product-colors"></section>
                                                    <section class="product-name"><h3>{{ \Illuminate\Support\Str::limit($mostVisitedProduct->name , 20) }}</h3></section>
                                                    <section class="product-price-wrapper">
                                                        @php

                                                            $amazingSale = $mostVisitedProduct->activeAmazingSales();
                                                            $totalDiscount = 0;

                                                        @endphp
                                                        @if(!empty($amazingSale))
                                                            @php
                                                                $totalDiscount = $mostVisitedProduct->price * ($amazingSale->percentage / 100);
                                                            @endphp
                                                        <section class="product-discount">
                                                            <span class="product-old-price">{{ priceFormat($mostVisitedProduct->price) }} تومان </span>
                                                            <span class="product-discount-amount">{{ $amazingSale->percentage }}%</span>
                                                        </section>
                                                        @endif
                                                        <section class="product-price">{{ priceFormat($mostVisitedProduct->price - $totalDiscount) }} تومان</section>
                                                    </section>
                                                    <section class="product-colors">
                                                        @foreach($mostVisitedProduct->colors()->get() as $color)
                                                        <section class="product-colors-item" style="background-color: {{ $color->color }};"></section>
                                                        @endforeach
                                                    </section>
                                                </a>
                                            </section>
                                        </section>
                                    </section>
                                    @endforeach
                                </section>
                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
        <!-- end product lazy load -->



        <!-- start ads section -->
        <section class="mb-3">
            <section class="container-xxl">
                <!-- two column-->
                <section class="row py-4">
                    @foreach($middleBanners as $middleBanner)
                    <section class="col-12 col-md-6 mt-2 mt-md-0"><img class="d-block rounded-2 w-100"  src="{{ $middleBanner->image }}" alt="{{ $middleBanner->title }}"></section>
                    @endforeach
                </section>

            </section>
        </section>
        <!-- end ads section -->


        <!-- start product lazy load -->
        <section class="mb-3">
            <section class="container-xxl" >
                <section class="row">
                    <section class="col">
                        <section class="content-wrapper bg-white p-3 rounded-2">
                            <!-- start vontent header -->
                            <section class="content-header">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title">
                                        <span>پیشنهاد آمازون به شما</span>
                                    </h2>
                                    <section class="content-header-link">
                                        <a href="{{ route('customer.products' , ['sort' => 5]) }}">مشاهده همه</a>
                                    </section>
                                </section>
                            </section>
                            <!-- start vontent header -->
                            <section class="lazyload-wrapper" >
                                <section class="lazyload light-owl-nav owl-carousel owl-theme">
                                    @foreach($offerProducts as $offerProduct)
                                        <section class="item">
                                            <section class="lazyload-item-wrapper">
                                                <section class="product">
                                                    {{--   <section class="product-add-to-cart"><a href="#" data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به سبد خرید"><i class="fa fa-cart-plus"></i></a></section>--}}

                                                    @guest
                                                        <section class="product-add-to-favorite">
                                                            <button data-url="{{ route('customer.market.add-to-favorite' , $offerProduct) }}" class=" btn btn-light btn-sm text-decoration-none"  data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به علاقه مندی">
                                                                <i class="fa fa-heart "></i>
                                                            </button>
                                                        </section>
                                                    @endguest

                                                    @auth
                                                        @if($offerProduct->user->contains(auth()->user()->id))
                                                            <section class="product-add-to-favorite">
                                                                <button data-url="{{ route('customer.market.add-to-favorite' , $offerProduct) }}" class=" btn btn-light btn-sm text-decoration-none"  data-bs-toggle="tooltip" data-bs-placement="left" title="حذف از علاقه مندی">
                                                                    <i class="fa fa-heart text-danger"></i>
                                                                </button>
                                                            </section>
                                                        @else
                                                            <section class="product-add-to-favorite">
                                                                <button data-url="{{ route('customer.market.add-to-favorite' , $offerProduct) }}" class=" btn btn-light btn-sm text-decoration-none"  data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به علاقه مندی">
                                                                    <i class="fa fa-heart "></i>
                                                                </button>
                                                            </section>
                                                        @endif
                                                    @endauth

                                                    <a class="product-link" href="{{ route('customer.market.product' , $offerProduct) }}">
                                                        <section class="product-image">
                                                            <img class="" src="{{ $offerProduct->image }}" alt="{{ $offerProduct->name }}">
                                                        </section>
                                                        <section class="product-colors"></section>
                                                        <section class="product-name"><h3>{{ \Illuminate\Support\Str::limit($offerProduct->name , 20) }}</h3></section>
                                                        <section class="product-price-wrapper">
                                                            @php

                                                                $amazingSale = $offerProduct->activeAmazingSales();
                                                                $totalDiscount = 0;

                                                            @endphp
                                                            @if(!empty($amazingSale))
                                                                @php
                                                                    $totalDiscount = $offerProduct->price * ($amazingSale->percentage / 100);
                                                                @endphp
                                                                <section class="product-discount">
                                                                    <span class="product-old-price">{{ priceFormat($offerProduct->price) }} تومان </span>
                                                                    <span class="product-discount-amount">{{ $amazingSale->percentage }}%</span>
                                                                </section>
                                                            @endif
                                                            <section class="product-price">{{ priceFormat($offerProduct->price - $totalDiscount) }} تومان</section>
                                                        </section>
                                                           <section class="product-colors">
                                                               @foreach($offerProduct->colors()->get() as $color)
                                                                   <section class="product-colors-item" style="background-color: {{ $color->color }};"></section>
                                                               @endforeach
                                                           </section>
                                                    </a>
                                                </section>
                                            </section>
                                        </section>
                                    @endforeach
                                </section>
                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
        <!-- end product lazy load -->

        @if(!empty($bottomBanner))
        <!-- start ads section -->
        <section class="mb-3">
            <section class="container-xxl">
                <!-- one column -->
                <section class="row py-4">
                    <section class="col"><img class="d-block rounded-2 w-100" src="{{ asset($bottomBanner->image) }}" alt="{{ $bottomBanner->title }}"></section>
                </section>
            </section>
        </section>
        <!-- end ads section -->
        @endif


        <!-- start brand part-->
        <section class="brand-part mb-4 py-4">
            <section class="container-xxl">
                <section class="row">
                    <section class="col">
                        <!-- start vontent header -->
                        <section class="content-header">
                            <section class="d-flex align-items-center">
                                <h2 class="content-header-title">
                                    <span>برندهای ویژه</span>
                                </h2>
                            </section>
                        </section>
                        <!-- start vontent header -->
                        <section class="brands-wrapper py-4" >
                            <section class="brands dark-owl-nav owl-carousel owl-theme">
                                @foreach($brands as $brand)
                                <section class="item">
                                    <section class="brand-item">
                                        <a href="{{ route('customer.products' , ['brands[]' => $brand->id]) }}"><img class="rounded-2" src="{{ asset($brand->logo['indexArray']['medium']) }}" alt="{{ $brand->persian_name }}"></a>
                                    </section>
                                </section>
                                @endforeach
                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
        <!-- end brand part-->


        <section class="position-fixed p-4 flex-row-reverse" style="z-index: 909999999; right: 0; top: 3rem; width: 26rem; max-width: 80%;">
            <div class="toast" data-delay="7000" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">فروشگاه</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <strong class="ml-auto">
                        برای افزودن کالا به لیست علاقه مندی ها باید ابتدا وارد حساب کاربری خود شوید
                        <br>
                        <a href="{{ route('auth.customer.login-register-form') }}" class="text-dark">
                            ثبت نام / ورود
                        </a>
                    </strong>
                </div>
            </div>
        </section>


@endsection
@section('script')

    <script>
        $('.product-add-to-favorite button').click(function() {
            var url = $(this).attr('data-url');
            var element = $(this);
            $.ajax({
                url : url,
                success : function(result){
                    if(result.status == 1)
                    {
                        $(element).children().first().addClass('text-danger');
                        $(element).attr('data-original-title', 'حذف از علاقه مندی ها');
                        $(element).attr('data-bs-original-title', 'حذف از علاقه مندی ها');
                    }
                    else if(result.status == 2)
                    {
                        $(element).children().first().removeClass('text-danger')
                        $(element).attr('data-original-title', 'افزودن از علاقه مندی ها');
                        $(element).attr('data-bs-original-title', 'افزودن از علاقه مندی ها');
                    }
                    else if(result.status == 3)
                    {
                        $('.toast').toast('show');
                    }
                }
            })
        })
    </script>


@endsection
