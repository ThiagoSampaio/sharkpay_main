@extends('layout')
@section('css')
<style>
    .about-shell {
        background: linear-gradient(180deg, #f6f7fc 0%, #ffffff 34%, #faf8ff 100%);
    }

    .about-section {
        padding: 88px 0;
    }

    .about-hero {
        background:
            radial-gradient(circle at top right, rgba(245, 138, 0, 0.14), transparent 24%),
            linear-gradient(145deg, #12192d 0%, #1f2746 58%, #161d37 100%);
        overflow: hidden;
        position: relative;
    }

    .about-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.04) 1px, transparent 1px);
        background-size: 44px 44px;
        opacity: 0.32;
        pointer-events: none;
    }

    .about-hero .container {
        position: relative;
        z-index: 1;
    }

    .about-pill {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 8px 16px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .about-title {
        color: #fff;
        font-size: 56px;
        line-height: 1.04;
        letter-spacing: -0.05em;
        font-weight: 800;
    }

    .about-copy {
        color: rgba(255, 255, 255, 0.78);
        font-size: 18px;
        line-height: 1.8;
    }

    .about-card,
    .about-review-card,
    .about-proof-card {
        position: relative;
        background: #fff;
        border: 1px solid rgba(123, 22, 244, 0.08);
        border-radius: 24px;
        box-shadow: 0 22px 50px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .about-card::before,
    .about-review-card::before,
    .about-proof-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #5d0fd3 0%, #7b16f4 68%, #f58a00 100%);
    }

    .about-card {
        padding: 40px;
    }

    .about-card h2,
    .about-review-wrap h3,
    .about-proof-card h4,
    .about-review-card h5 {
        color: #1d2542;
        font-weight: 800;
    }

    .about-card,
    .about-card p,
    .about-card li,
    .about-review-card p,
    .about-proof-card p {
        color: #667085;
        line-height: 1.82;
    }

    .about-card h1,
    .about-card h2,
    .about-card h3,
    .about-card h4,
    .about-card h5,
    .about-card h6 {
        color: #1d2542;
        margin-bottom: 18px;
    }

    .about-card p:last-child {
        margin-bottom: 0;
    }

    .about-proof-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-top: 24px;
    }

    .about-proof-card {
        padding: 24px;
        background: linear-gradient(180deg, #ffffff 0%, #fbfaff 100%);
    }

    .about-proof-card span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        border-radius: 18px;
        margin-bottom: 16px;
        color: #fff;
        font-size: 22px;
        background: linear-gradient(135deg, #5d0fd3 0%, #7b16f4 60%, #f58a00 100%);
    }

    .about-review-wrap {
        padding-top: 10px;
    }

    .about-review-card {
        padding: 28px;
        background: linear-gradient(180deg, #ffffff 0%, #fcfbff 100%);
    }

    .about-review-mark {
        display: block;
        margin-bottom: 12px;
        color: rgba(123, 22, 244, 0.16);
        font-size: 60px;
        line-height: 1;
    }

    .about-review-person {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-top: 22px;
    }

    .about-review-person img {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        object-fit: cover;
    }

    .about-review-person span {
        display: block;
        color: #667085;
        font-size: 14px;
    }

    @media (max-width: 991px) {
        .about-section {
            padding: 70px 0;
        }

        .about-title {
            font-size: 42px;
        }

        .about-proof-grid {
            grid-template-columns: 1fr;
        }

        .about-card {
            padding: 26px;
        }
    }
</style>
@stop
@section('content')
<div class="about-shell">
    <section class="about-section about-hero">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-7 m-15px-tb">
                    <span class="about-pill m-25px-b">
                        <i class="fal fa-building"></i>
                        {{$set->title}}
                    </span>
                    <h1 class="about-title m-25px-b">{{$lang['about_about']}} {{$set->site_name}}</h1>
                    <p class="about-copy m-0px">Uma presença institucional mais consistente para explicar quem a plataforma atende, como ela opera e por que transmite confiança desde o primeiro contato.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="about-section">
        <div class="container">
            <div class="about-card">
                {!!$about->about!!}
                <div class="about-proof-grid">
                    <div class="about-proof-card">
                        <span><i class="fal fa-layer-group"></i></span>
                        <h4 class="m-10px-b">Posicionamento claro</h4>
                        <p class="m-0px">A apresentacao institucional agora conversa com a nova home e transmite mais maturidade de produto.</p>
                    </div>
                    <div class="about-proof-card">
                        <span><i class="fal fa-shield-check"></i></span>
                        <h4 class="m-10px-b">Confianca visivel</h4>
                        <p class="m-0px">Identidade, estrutura e linguagem trabalham juntas para reforcar robustez operacional.</p>
                    </div>
                    <div class="about-proof-card">
                        <span><i class="fal fa-chart-network"></i></span>
                        <h4 class="m-10px-b">Narrativa de plataforma</h4>
                        <p class="m-0px">O conteudo institucional ganha contexto de plataforma, nao apenas de pagina informativa.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(count($review)>0)
    <section class="about-section pt-0">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-5 m-15px-tb">
                    <img src="{{url('/')}}/asset/images/{{$ui->s7_image}}" alt="{{$ui->s7_title}}">
                </div>
                <div class="col-lg-6 m-15px-tb about-review-wrap">
                    <span class="home-pill m-20px-b">prova social</span>
                    <h3 class="h1 m-20px-b">{{$ui->s7_title}}</h3>
                    <div class="owl-carousel owl-nav-arrow-bottom" data-items="1" data-nav-arrow="true" data-nav-dots="false" data-md-items="1" data-sm-items="1" data-xs-items="1" data-xx-items="1" data-space="20" data-autoplay="true">
                        @foreach($review as $vreview)
                        <div class="about-review-card">
                            <span class="about-review-mark">“</span>
                            <p class="m-0px">{{$vreview->review}}</p>
                            <div class="about-review-person">
                                <img src="{{url('/')}}/asset/review/{{$vreview->image_link}}" alt="{{$vreview->name}}">
                                <div>
                                    <h5 class="m-0px">{{$vreview->name}}</h5>
                                    <span>{{$vreview->occupation}}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
</div>
@stop