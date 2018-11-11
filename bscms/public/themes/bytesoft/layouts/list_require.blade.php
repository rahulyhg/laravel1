<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,  initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <link rel="canonical" href="{{ url('/') }}">
    <meta http-equiv="content-language" content="{{ app()->getLocale() }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
    {!! Theme::header() !!}
</head>
<body>
{!! Theme::partial('header') !!}
<main id="main" class="main-pages">
    <section class="section-banner while_after">
        <div class="banner-page">
            <div class="bs-container">
                <div class="banner-text">
                    <h4 class="title" data-aos="zoom-out" data-aos-delay="1200">
                        TUYỂN DỤNG BYTESOFT
                    </h4>
                    <ul class="link-list">
                        <li class="link-list__item">
                            <a href="" class="link-list__link">Trang chủ</a>
                        </li>
                        <li class="link-list__item">
                            <a href="" class="link-list__link">Tuyển dụng</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="section-recruit">
        <div class="bs-container">
            <div class="bs-row">
                <div class="bs-col">
                    <div class="module module-recruit">
                        <div class="module-content">
                            <div class="recruitment">
                                <div class="item border-item">
                                    <div class="center">
                                        <div class="bs-row  row-sm-10 row-center">
                                            <div class="bs-col md-30-10 sm-40-10">
                                                <div class="location">
                                                    <input type="text" placeholder="Nhập vị trí ứng tuyển...">
                                                </div>
                                            </div>
                                            <div class="bs-col md-30-10 sm-40-10">
                                                <select class="select" name="state">
                                                    <option value="">Tất cả</option>
                                                    <option value="">Tất cả</option>
                                                </select>
                                            </div>
                                            <div class="bs-col md-15-10 sm-20-10">
                                                <div class="search">
                                                    <button type="button">TÌM KIẾM</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @foreach(get_all_jobs() as $job)
                                <div class="item">
                                    <div class="bs-row row-sm-15">
                                        <div class="bs-col sm-30-15">
                                            <div class="img">
                                                <div class="ImagesFrame">
                                                    <div class="ImagesFrameCrop0">
                                                        @if($job->image=='')
                                                            <img src="{!! Theme::asset()->url('images/no-image-icon-15.png
') !!}" alt="$job->name ">
                                                            @else  
                                                            <img src="{{ $job->image }}"
                                                                alt="{{ $job->name }}">
                                                            @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bs-col sm-70-15">
                                            <div class="right">
                                            	

                                                <h4 class="title"><a href="">{{ $job->name }}</a> </h4>
                                                <div class="date">
                                                    <p class="date-posts"><i class="fas fa-calendar-alt"></i>Ngày đăng:{{ date_from_database($job->created_at,'d/m/Y') }}</p>
                                                    <p class="deadline"><i class="fas fa-clock"></i>Hạn nộp:{{ date_from_database($job->expiration_at, 'd/m/Y') }}</p>
                                                </div>
                                                <div class="desc">
                                                    <p>{!! str_limit($job->description) !!}</p>
                                                </div>
                                                <div class="link">
                                                    <a href="{{ route('public.single', $job->slug) }}" class="see-all">XEM THÊM</a>
                                                    <a href="" class="apply">ỨNG TUYỂN NGAY</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="pag">
                                    <ul class="content-pag">
                                        <li class="item-pag"><a href="" class="pag_link">1</a></li>
                                        <li class="item-pag"><a href="" class="pag_link">2</a></li>
                                        <li class="item-pag"><a href="" class="pag_link"><i class="fas fa-angle-right"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-slogan">
        <div class="bs-container">
            <p class="desc" data-aos="zoom-out" data-aos-delay="0">Chúng tôi ở đây để làm mọi thứ tốt hơn</p>
        </div>
    </section>
</main>

{!! Theme::partial('footer') !!}

{!! Theme::footer() !!}

</body>
</html>