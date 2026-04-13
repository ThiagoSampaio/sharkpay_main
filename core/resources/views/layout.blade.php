<!doctype html>
<html class="no-js" lang="en">
    <head>
        <base href="{{url('/')}}"/>
        <title>{{ $title }} - {{$set->site_name}}</title>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="robots" content="index, follow">
        <meta name="apple-mobile-web-app-title" content="{{$set->site_name}}"/>
        <meta name="application-name" content="{{$set->site_name}}"/>
        <meta name="msapplication-TileColor" content="#ffffff"/>
        <meta name="description" content="{{$set->site_desc}}" />
        <link rel="shortcut icon" href="{{url('/')}}/asset/{{$logo->image_link2}}" />
        <link href="{{url('/')}}/asset/static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{url('/')}}/asset/static/plugin/font-awesome/css/all.min.css" rel="stylesheet">
        <link href="{{url('/')}}/asset/static/plugin/et-line/style.css" rel="stylesheet">
        <link href="{{url('/')}}/asset/static/plugin/themify-icons/themify-icons.css" rel="stylesheet">
        <link href="{{url('/')}}/asset/static/plugin/ionicons/css/ionicons.min.css" rel="stylesheet">
        <link href="{{url('/')}}/asset/static/plugin/owl-carousel/css/owl.carousel.min.css" rel="stylesheet">
        <link href="{{url('/')}}/asset/static/plugin/magnific/magnific-popup.css" rel="stylesheet">
        <link href="{{url('/')}}/asset/static/style/master.css" rel="stylesheet">
        <link rel="stylesheet" href="{{url('/')}}/asset/css/toast.css" type="text/css">
        <link href="{{url('/')}}/asset/fonts/fontawesome/css/all.css" rel="stylesheet" type="text/css">
        <!-- Bootstrap Icons CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">


        <style>
            :root {
                --sharkpay-purple: #7b16f4;
                --sharkpay-purple-dark: #5d0fd3;
                --sharkpay-purple-soft: #f5eeff;
                --sharkpay-orange: #f58a00;
                --sharkpay-ink: #1d2542;
                --sharkpay-slate: #667085;
                --sharkpay-border: #e8e8f2;
                --sharkpay-surface: #ffffff;
                --sharkpay-surface-soft: #f7f8fc;
                --sharkpay-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
            }

            .custom-spinner-loader {
                border: 16px solid #f3f3f3;
                border-top: 16px solid #3498db;
                border-radius: 50%;
                width: 120px;
                height: 120px;
                animation: spin 2s linear infinite;
            }

            body.public-site {
                background: linear-gradient(180deg, #f6f7fc 0%, #ffffff 100%);
                color: var(--sharkpay-ink);
            }

            .public-header .fixed-header-bar {
                padding-top: 18px;
            }

            .public-header .navbar-main {
                padding: 14px 18px;
                background: rgba(255, 255, 255, 0.9);
                border: 1px solid rgba(123, 22, 244, 0.08);
                border-radius: 24px;
                backdrop-filter: blur(12px);
                box-shadow: var(--sharkpay-shadow);
            }

            .public-header .navbar-brand img {
                max-width: 220px !important;
            }

            .public-header .nav-link {
                color: var(--sharkpay-ink) !important;
                font-weight: 600;
            }

            .public-header .nav-link:hover,
            .public-header .nav-link:focus {
                color: var(--sharkpay-purple-dark) !important;
            }

            .public-header .px-dropdown-menu {
                border: 1px solid rgba(123, 22, 244, 0.1);
                border-radius: 18px;
                box-shadow: var(--sharkpay-shadow);
                overflow: hidden;
            }

            .public-nav-actions {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 10px;
                margin-left: 20px;
            }

            .public-action-link {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-height: 44px;
                padding: 0 18px;
                border-radius: 999px;
                font-size: 14px;
                font-weight: 700;
                transition: .25s ease;
            }

            .public-action-link--ghost {
                color: var(--sharkpay-purple-dark);
                background: var(--sharkpay-purple-soft);
            }

            .public-action-link--ghost:hover {
                color: var(--sharkpay-purple-dark);
                background: #ede2ff;
            }

            .public-action-link--primary {
                color: #fff;
                background: linear-gradient(135deg, var(--sharkpay-purple-dark) 0%, var(--sharkpay-purple) 60%, var(--sharkpay-orange) 100%);
                box-shadow: 0 14px 28px rgba(123, 22, 244, 0.18);
            }

            .public-action-link--primary:hover {
                color: #fff;
                transform: translateY(-1px);
            }

            .public-main {
                min-height: calc(100vh - 220px);
            }

            .public-footer {
                margin-top: 40px;
                background:
                    radial-gradient(circle at top right, rgba(245, 138, 0, 0.16), transparent 22%),
                    linear-gradient(145deg, #141c34 0%, #1d2542 58%, #101727 100%);
                color: rgba(255, 255, 255, 0.82);
            }

            .public-footer .footer-top {
                padding-top: 20px;
            }

            .public-footer .footer-title,
            .public-footer h4,
            .public-footer h5 {
                color: #fff;
                font-weight: 700;
            }

            .public-footer p,
            .public-footer li,
            .public-footer a {
                color: rgba(255, 255, 255, 0.74);
            }

            .public-footer a:hover {
                color: #fff;
            }

            .public-footer-brand {
                max-width: 360px;
            }

            .public-footer-copy {
                margin-top: 18px;
                font-size: 15px;
                line-height: 1.8;
            }

            .public-footer-badge {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                padding: 8px 14px;
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.08);
                color: #fff;
                font-size: 12px;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            .public-footer .social-icon a {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.08);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            .public-footer .footer-bottom {
                border-top: 1px solid rgba(255, 255, 255, 0.08);
                margin-top: 12px;
                padding-top: 24px;
                padding-bottom: 24px;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            @media (max-width: 991px) {
                .public-header .navbar-main {
                    padding: 12px 14px;
                }

                .public-nav-actions {
                    margin-left: 0;
                    margin-top: 14px;
                }
            }
        </style>
         @yield('css')
    </head>

    <body class="public-site" data-spy="scroll" data-target="#navbar-collapse-toggle" data-offset="98">
    <!-- Preload -->
    <!--
    <div id="loading">
        <div class="load-circle"><span class="one"></span></div>
    </div>
    -->
    <!-- End Preload -->
    <!-- Header -->
    <header class="header-nav header-dark public-header">
        <div class="fixed-header-bar">
            <!-- Header Nav -->
            <div class="navbar navbar-main navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand" href="{{url('/')}}">
                        <img alt="" title="" src="{{url('/')}}/asset/{{$logo->image_link}}" style="max-width: 280px;">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-main-collapse" aria-controls="navbar-main-collapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse navbar-collapse-overlay" id="navbar-main-collapse">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('about')}}">{{$lang["layout_why"]}} {{$set->site_name}}</a>
                            </li>                                                         
                            <li class="nav-item mm-in px-dropdown">
                                <a class="nav-link">{{$lang["layout_features"]}}</a>
                                <ul class="px-dropdown-menu mm-dorp-in">
                                    @if($set->transfer==1)      
                                    <li><a href="{{route('user.transfer')}}">{{$lang["layout_transfer_money"]}}</a></li>
                                    @endif
                                    @if($set->request_money==1)
                                    <li><a href="{{route('user.request')}}">{{$lang["layout_request_money"]}}</a></li>
                                    @endif
                                    @if($set->vcard==1)
                                    <li><a href="{{route('user.virtualcard')}}">{{$lang["layout_virtual_cards"]}}</a></li>
                                    @endif
                                    @if($set->bill==1) 
                                    <li><a href="{{route('user.airtime')}}">{{$lang["layout_bill_payment"]}}</a></li>
                                    @endif
                                    <li><a href="{{route('user.subaccounts')}}">{{$lang["layout_sub_accounts"]}}</a></li>
                                    @if($set->store==1) 
                                    <li><a href="{{route('user.storefront')}}">{{$lang["layout_store_front"]}}</a></li>
                                    @endif
                                    @if($set->single==1)
                                    <li><a href="{{route('user.sclinks')}}">{{$lang["layout_single_charge"]}}</a></li>
                                    @endif
                                    @if($set->donation==1) 
                                    <li><a href="{{route('user.dplinks')}}">{{$lang["layout_donations"]}}</a></li>
                                    @endif
                                    @if($set->invoice==1) 
                                    <li><a href="{{route('user.invoice')}}">{{$lang["layout_invoice"]}}</a></li>
                                    @endif
                                    @if($set->subscription==1)
                                    <li><a href="{{route('user.plan')}}">{{$lang["layout_subscription_service"]}}</a></li>
                                    @endif
                                    @if($set->merchant==1)
                                    <li><a href="{{route('user.merchant')}}">{{$lang["layout_website_integration"]}}</a></li>
                                    @endif
                                </ul>
                            </li>                            
                            <li class="nav-item mm-in px-dropdown">
                                <a class="nav-link">{{$lang["layout_help"]}}</a>
                                <ul class="px-dropdown-menu mm-dorp-in">
                                    <li><a href="{{route('faq')}}">{{$lang["layout_faqs"]}}</a></li>
                                    <li><a href="{{route('contact')}}">{{$lang["layout_contact_us"]}}</a></li>
                                </ul>
                            </li> 
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('blog')}}">{{$lang["layout_blog"]}}</a>
                            </li>                           
                        </ul>
                        <div class="public-nav-actions">
                            @if (Auth::guard('user')->check())
                                <a class="public-action-link public-action-link--primary" href="{{route('user.dashboard')}}">{{$lang['front_dashboard']}}</a>
                            @else
                                <a class="public-action-link public-action-link--ghost" href="{{route('login')}}">{{$lang['front_sign_in']}}</a>
                                <a class="public-action-link public-action-link--primary" href="{{route('register')}}">{{$lang['front_get_started']}}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Header Nav -->
        </div>
    </header>
    <!-- Header End -->
    <!-- Main -->
    <main class="public-main">
@yield('content')
    <footer class="footer effect-section p-60px-t public-footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 m-15px-tb">
                        <div class="row">
                            <div class="col-lg-6">
                                <span class="public-footer-badge">infraestrutura comercial digital</span>
                                <div class="p-25px-b">
                                    <img class="logo-dark nav-img" alt="" title="" src="{{url('/')}}/asset/{{$logo->image_link}}">
                                </div>
                                <p class="public-footer-copy">
                                    {{$set->site_desc}}
                                </p>
                                <div class="social-icon si-30 theme round nav">
                                    @foreach($social as $socials)
                                        @if(!empty($socials->value))
                                            <a href="{{$socials->value}}" ><i class="fab fa-{{$socials->type}}"></i></a>
                                        @endif
                                    @endforeach 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 m-15px-tb">
                        <h5 class="footer-title">{{$lang["layout_our_solutions"]}}</h5>
                        <div class="row">
                            <div class="col-lg-4 m-15px-tb">
                                <ul class="list-unstyled links-dark footer-link-1">
                                    @if($set->transfer==1)      
                                    <li><a href="{{route('user.transfer')}}">{{$lang["layout_transfer_money"]}}</a></li>
                                    @endif
                                    @if($set->request_money==1)
                                    <li><a href="{{route('user.request')}}">{{$lang["layout_request_money"]}}</a></li>
                                    @endif
                                    @if($set->vcard==1)
                                    <li><a href="{{route('user.virtualcard')}}">{{$lang["layout_virtual_cards"]}}</a></li>
                                    @endif
                                    @if($set->bill==1) 
                                    <li><a href="{{route('user.airtime')}}">{{$lang["layout_bill_payment"]}}</a></li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-lg-4 m-15px-tb">
                                <ul class="list-unstyled links-dark footer-link-1">
                                    <li><a href="{{route('user.subaccounts')}}">{{$lang["layout_sub_accounts"]}}</a></li>
                                    @if($set->store==1) 
                                    <li><a href="{{route('user.storefront')}}">{{$lang["layout_store_front"]}}</a></li>
                                    @endif
                                    @if($set->single==1)
                                    <li><a href="{{route('user.sclinks')}}">{{$lang["layout_single_charge"]}}</a></li>
                                    @endif
                                    @if($set->donation==1) 
                                    <li><a href="{{route('user.dplinks')}}">{{$lang["layout_donations"]}}</a></li>
                                    @endif
                                </ul>
                            </div>                
                            <div class="col-lg-4 m-15px-tb">
                                <ul class="list-unstyled links-dark footer-link-1">
                                    @if($set->invoice==1) 
                                    <li><a href="{{route('user.invoice')}}">{{$lang["layout_invoice"]}}</a></li>
                                    @endif
                                    @if($set->subscription==1)
                                    <li><a href="{{route('user.plan')}}">{{$lang["layout_subscription_service"]}}</a></li>
                                    @endif
                                    @if($set->merchant==1)
                                    <li><a href="{{route('user.merchant')}}">{{$lang["layout_website_integration"]}}</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>                        
                        <div class="row">             
                            <div class="col-lg-4 m-15px-tb">
                                <h5 class="footer-title">
                                {{$lang["layout_help"]}}
                                </h5>
                                <ul class="list-unstyled links-dark footer-link-1">
                                    <li><a href="{{url('/')}}/contact" >{{$lang["layout_contact"]}}</a></li>
                                    <li><a href="{{url('/')}}/faq">{{$lang["layout_faqs"]}}</a></li>
                                    <li><a href="{{route('terms')}}" >{{$lang["layout_terms_of_use"]}}</a></li>
                                    <li><a href="{{route('privacy')}}" >{{$lang["layout_privacy_police"]}}</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-4 m-15px-tb">
                                <h5 class="footer-title">
                                {{$lang["layout_more"]}}
                                </h5>
                                <ul class="list-unstyled links-dark footer-link-1">
                                    @foreach($pages as $vpages)
                                        @if(!empty($vpages))
                                    <li><a href="{{url('/')}}/page/{{$vpages->id}}">{{$vpages->title}}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom footer-border-dark">
            <div class="container">
                <div class="row">
                    <div class="col-md-6  m-5px-tb">
                        <h4>{{$lang["layout_company_info"]}}</h4>
                        @if(!empty($set->company_name))
                        <p class="m-0px ">{{$set->company_name}}</p>
                        @endif
                        @if(!empty($set->company_document))
                        <p class="m-0px ">{{$set->company_document}}</p>
                        @endif
                        @if(!empty($set->company_address))
                        <p class="m-0px ">{{$set->company_address}}</p>
                        @endif
                        
                        <ul class="nav justify-content-center justify-content-md-start links-dark font-small footer-link-1">
                        </ul>
                    </div>
                    <div class="col-md-6 text-center text-md-right m-5px-tb">
                        <p class="m-0px font-small">{{$set->site_name}}  &copy; {{date('Y')}}. {{$lang["layout_all_rights_reserved"]}}.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
{!!$livechatCode!!}
        <script>
            var urx = "{{url('/')}}";
        </script>
        <script src="{{url('/')}}/asset/static/js/jquery-3.2.1.min.js"></script>
        <script src="{{url('/')}}/asset/static/js/jquery-migrate-3.0.0.min.js"></script>
        <script src="{{url('/')}}/asset/static/plugin/appear/jquery.appear.js"></script>
        <script src="{{url('/')}}/asset/static/plugin/bootstrap/js/popper.min.js"></script>
        <script src="{{url('/')}}/asset/static/plugin/bootstrap/js/bootstrap.js"></script>
        <script src="{{url('/')}}/asset/static/js/custom.js"></script>
        <script src="{{url('/')}}/asset/js/toast.js"></script>
@yield('script')
@if (session('success'))
    <script>
      "use strict";
      toastr.success("{{ session('success') }}");
    </script>    
@endif

@if (session('alert'))
    <script>
      "use strict";
      toastr.warning("{{ session('alert') }}");
    </script>
@endif

</body>
</html>