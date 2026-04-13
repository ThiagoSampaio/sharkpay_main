@extends('layout')
@section('css')
<style>
    :root {
        --sharkpay-purple: #7b16f4;
        --sharkpay-purple-dark: #5d0fd3;
        --sharkpay-purple-soft: #f5eeff;
        --sharkpay-orange: #f58a00;
        --sharkpay-orange-soft: #fff4e6;
        --sharkpay-ink: #1d2542;
        --sharkpay-slate: #667085;
        --sharkpay-border: #e8e8f2;
        --sharkpay-surface: #ffffff;
        --sharkpay-surface-soft: #f7f8fc;
        --sharkpay-shadow: 0 22px 50px rgba(15, 23, 42, 0.08);
    }

    .home-shell {
        background: linear-gradient(180deg, #f6f7fc 0%, #ffffff 30%, #f9f8ff 100%);
    }

    .home-section {
        position: relative;
        padding: 88px 0;
    }

    .home-section--tight {
        padding: 42px 0;
    }

    .home-section--soft {
        background: linear-gradient(180deg, #f7f8fc 0%, #fcfbff 100%);
    }

    .home-section--dark {
        background:
            radial-gradient(circle at top right, rgba(245, 138, 0, 0.18), transparent 24%),
            linear-gradient(145deg, #12192d 0%, #1f2746 58%, #161d37 100%);
        overflow: hidden;
    }

    .home-section--dark::before {
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

    .home-section--dark .container {
        position: relative;
        z-index: 1;
    }

    .home-pill {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 8px 16px;
        border-radius: 999px;
        background: var(--sharkpay-purple-soft);
        color: var(--sharkpay-purple-dark);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .home-pill--dark {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .home-display {
        color: #fff;
        font-size: 60px;
        line-height: 1.02;
        letter-spacing: -0.05em;
        font-weight: 800;
    }

    .home-title {
        color: var(--sharkpay-ink);
        font-size: 42px;
        line-height: 1.08;
        letter-spacing: -0.04em;
        font-weight: 800;
    }

    .home-copy {
        color: var(--sharkpay-slate);
        font-size: 18px;
        line-height: 1.82;
    }

    .home-section--dark .home-copy,
    .home-section--dark .home-meta {
        color: rgba(255, 255, 255, 0.78);
    }

    .home-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
    }

    .home-actions .m-btn {
        margin: 0;
    }

    .home-signal-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-top: 26px;
    }

    .home-signal {
        padding: 18px 18px 16px;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.14);
        backdrop-filter: blur(8px);
    }

    .home-signal strong {
        display: block;
        color: #fff;
        font-size: 28px;
        line-height: 1;
        margin-bottom: 8px;
        font-weight: 800;
    }

    .home-signal span {
        color: rgba(255, 255, 255, 0.7);
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .home-meta {
        font-size: 14px;
        letter-spacing: 0.02em;
    }

    .home-command {
        padding: 28px;
        border-radius: 28px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.14);
        box-shadow: 0 28px 70px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(12px);
    }

    .home-command__frame {
        padding: 22px;
        border-radius: 24px;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.94) 0%, rgba(248, 247, 255, 0.88) 100%);
        border: 1px solid rgba(123, 22, 244, 0.12);
    }

    .home-command__eyebrow {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
        color: var(--sharkpay-slate);
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 700;
    }

    .home-status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--sharkpay-orange);
        box-shadow: 0 0 0 8px rgba(245, 138, 0, 0.12);
    }

    .home-command__hero {
        padding: 18px 20px;
        border-radius: 22px;
        background: linear-gradient(135deg, var(--sharkpay-purple-dark) 0%, var(--sharkpay-purple) 62%, var(--sharkpay-orange) 100%);
        color: #fff;
        margin-bottom: 18px;
    }

    .home-command__hero h4 {
        color: #fff;
        margin-bottom: 8px;
        font-weight: 700;
    }

    .home-command__hero p {
        margin: 0;
        color: rgba(255, 255, 255, 0.84);
        font-size: 15px;
        line-height: 1.7;
    }

    .home-command__grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .home-command__metric,
    .home-command__item {
        padding: 18px;
        border-radius: 18px;
        background: #fff;
        border: 1px solid rgba(123, 22, 244, 0.08);
    }

    .home-command__metric strong {
        display: block;
        color: var(--sharkpay-ink);
        font-size: 24px;
        line-height: 1;
        margin-bottom: 6px;
    }

    .home-command__metric span,
    .home-command__item p {
        color: var(--sharkpay-slate);
        font-size: 14px;
        margin: 0;
        line-height: 1.7;
    }

    .home-command__item h5 {
        color: var(--sharkpay-ink);
        font-size: 16px;
        margin-bottom: 6px;
        font-weight: 700;
    }

    .home-trust-strip {
        padding: 22px;
        border-radius: 24px;
        background: linear-gradient(180deg, #ffffff 0%, #fbfaff 100%);
        border: 1px solid rgba(123, 22, 244, 0.08);
        box-shadow: var(--sharkpay-shadow);
    }

    .home-trust-strip__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        margin-bottom: 18px;
    }

    .home-trust-strip__header h4 {
        margin: 0;
        color: var(--sharkpay-ink);
        font-weight: 700;
    }

    .home-trust-strip__header p {
        margin: 0;
        color: var(--sharkpay-slate);
        font-size: 14px;
    }

    .home-trust-strip img {
        max-height: 38px;
        width: auto !important;
        margin: 0 auto;
        opacity: 0.92;
        filter: grayscale(0.2);
    }

    .home-story-card,
    .home-capability-card,
    .home-rail-card,
    .home-review-card,
    .home-cta-card {
        background: var(--sharkpay-surface);
        border: 1px solid rgba(123, 22, 244, 0.08);
        border-radius: 24px;
        box-shadow: var(--sharkpay-shadow);
    }

    .home-story-card,
    .home-cta-card {
        overflow: hidden;
        position: relative;
    }

    .home-story-card::before,
    .home-capability-card::before,
    .home-rail-card::before,
    .home-review-card::before,
    .home-cta-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--sharkpay-purple-dark) 0%, var(--sharkpay-purple) 68%, var(--sharkpay-orange) 100%);
    }

    .home-story-card {
        padding: 38px;
    }

    .home-story-media img,
    .home-rail-visual img,
    .home-review-visual img {
        width: 100%;
    }

    .home-pillars {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-top: 26px;
    }

    .home-pillar {
        padding: 18px;
        border-radius: 18px;
        background: var(--sharkpay-surface-soft);
        border: 1px solid var(--sharkpay-border);
    }

    .home-pillar strong {
        display: block;
        margin-bottom: 8px;
        color: var(--sharkpay-ink);
        font-size: 16px;
    }

    .home-pillar span {
        color: var(--sharkpay-slate);
        font-size: 14px;
        line-height: 1.7;
    }

    .home-capability-card,
    .home-rail-card,
    .home-review-card {
        position: relative;
        height: 100%;
        padding: 28px;
        overflow: hidden;
    }

    .home-capability-icon,
    .home-rail-icon {
        width: 62px;
        height: 62px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        font-size: 24px;
        color: #fff;
        background: linear-gradient(135deg, var(--sharkpay-purple-dark) 0%, var(--sharkpay-purple) 60%, var(--sharkpay-orange) 100%);
        box-shadow: 0 16px 30px rgba(123, 22, 244, 0.18);
        margin-bottom: 18px;
    }

    .home-capability-card h5,
    .home-rail-card h5,
    .home-review-card h5,
    .home-cta-card h3 {
        color: var(--sharkpay-ink);
        font-weight: 700;
    }

    .home-capability-card p,
    .home-rail-card p,
    .home-review-card p {
        color: var(--sharkpay-slate);
        margin: 0;
        line-height: 1.75;
    }

    .home-review-card {
        background: linear-gradient(180deg, #ffffff 0%, #fcfbff 100%);
    }

    .home-review-mark {
        color: rgba(123, 22, 244, 0.16);
        font-size: 60px;
        line-height: 1;
        display: block;
        margin-bottom: 12px;
    }

    .home-review-person {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-top: 22px;
    }

    .home-review-person img {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        object-fit: cover;
    }

    .home-review-person span {
        display: block;
        color: var(--sharkpay-slate);
        font-size: 14px;
    }

    .home-cta-card {
        padding: 42px;
        background:
            radial-gradient(circle at top right, rgba(245, 138, 0, 0.18), transparent 28%),
            linear-gradient(135deg, #ffffff 0%, #fbf9ff 100%);
    }

    .home-cta-card .home-title {
        max-width: 760px;
        margin-left: auto;
        margin-right: auto;
    }

    .home-cta-card .home-copy {
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    .home-cta-actions {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 12px;
        margin-top: 28px;
    }

    @media (max-width: 991px) {
        .home-section {
            padding: 70px 0;
        }

        .home-display {
            font-size: 44px;
        }

        .home-title {
            font-size: 34px;
        }

        .home-signal-grid,
        .home-pillars,
        .home-command__grid {
            grid-template-columns: 1fr;
        }

        .home-story-card,
        .home-cta-card,
        .home-command {
            padding: 24px;
        }

        .home-trust-strip__header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@stop
@section('content')
@php
    $serviceCount = isset($item) ? count($item) : 0;
    $brandCount = isset($brand) ? count($brand) : 0;
    $reviewCount = isset($review) ? count($review) : 0;
@endphp

<div class="home-shell">
    <section class="home-section home-section--dark">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 m-15px-tb">
                    <span class="home-pill home-pill--dark m-25px-b">
                        <i class="fal fa-bolt"></i>
                        {{$set->title}}
                    </span>
                    <h1 class="home-display m-25px-b">{{$ui->header_title}}</h1>
                    <p class="home-copy m-35px-b">{{$ui->header_body}}</p>
                    <div class="home-actions m-10px-b">
                        @if (Auth::guard('user')->check())
                            <a class="m-btn m-btn-radius m-btn-t-dark" href="{{route('user.dashboard')}}">
                                <span class="m-btn-inner-text">{{$lang['front_dashboard']}}</span>
                                <span class="m-btn-inner-icon arrow"></span>
                            </a>
                        @else
                            <a class="m-btn m-btn-radius m-btn-t-dark" href="{{route('login')}}">
                                <span class="m-btn-inner-text">{{$lang['front_sign_in']}}</span>
                                <span class="m-btn-inner-icon arrow"></span>
                            </a>
                            <a class="m-btn m-btn-radius m-btn-theme-light" href="{{route('register')}}">
                                <span class="m-btn-inner-text">{{$lang['front_get_started']}}</span>
                            </a>
                        @endif
                        <a class="m-btn m-btn-radius m-btn-border" href="{{route('about')}}">
                            <span class="m-btn-inner-text">{{$lang['front_more_abount_us']}}</span>
                        </a>
                    </div>
                    <div class="home-signal-grid">
                        <div class="home-signal">
                            <strong>{{$serviceCount}}</strong>
                            <span>solucoes ativas</span>
                        </div>
                        <div class="home-signal">
                            <strong>{{$brandCount}}</strong>
                            <span>marcas e integracoes</span>
                        </div>
                        <div class="home-signal">
                            <strong>{{$reviewCount}}</strong>
                            <span>avaliacoes publicas</span>
                        </div>
                    </div>
                    <p class="home-meta m-20px-t m-0px-b">Infraestrutura comercial apresentada com mais clareza, credibilidade e senso de produto para operacoes digitais em escala.</p>
                </div>
                <div class="col-lg-5 m-15px-tb">
                    <div class="home-command">
                        <div class="home-command__frame">
                            <div class="home-command__eyebrow">
                                <span>painel de operacao</span>
                                <span class="home-status-dot"></span>
                            </div>
                            <div class="home-command__hero">
                                <h4>{{$set->site_name}}</h4>
                                <p>Recebimento, cobranca, loja e relacionamento organizados como plataforma, com leitura executiva e narrativa mais madura para negocios digitais.</p>
                            </div>
                            <div class="home-command__grid">
                                <div class="home-command__metric">
                                    <strong>{{$serviceCount}}</strong>
                                    <span>frentes de receita conectadas</span>
                                </div>
                                <div class="home-command__metric">
                                    <strong>{{$brandCount}}</strong>
                                    <span>camadas de confianca visiveis</span>
                                </div>
                                <div class="home-command__item">
                                    <h5>{{$lang['front_payment_pages']}}</h5>
                                    <p>Paginas de cobranca desenhadas para reduzir friccao e acelerar entendimento.</p>
                                </div>
                                <div class="home-command__item">
                                    <h5>{{$lang['front_storefront']}}</h5>
                                    <p>Catalogo, pedidos e recebimento conectados em uma experiencia comercial unica.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($brandCount > 0)
    <section class="home-section home-section--tight">
        <div class="container">
            <div class="home-trust-strip">
                <div class="home-trust-strip__header">
                    <div>
                        <h4>Credibilidade apresentada desde o primeiro scroll</h4>
                        <p>Marcas, parceiros e integracoes aparecem cedo na narrativa para reforcar robustez e legitimidade.</p>
                    </div>
                    <span class="home-pill">brand proof</span>
                </div>
                <div class="owl-carousel owl-loaded owl-drag" data-items="6" data-nav-dots="false" data-md-items="5" data-sm-items="4" data-xs-items="3" data-xx-items="2" data-space="24" data-autoplay="true">
                    @foreach($brand as $brands)
                        <div class="p-10px">
                            <img src="{{url('/')}}/asset/brands/{{$brands->image}}" alt="{{$brands->name ?? $set->title}}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    <section class="home-section">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 m-15px-tb">
                    <div class="home-story-media text-center">
                        <img src="{{url('/')}}/asset/images/{{$ui->s3_image}}" alt="{{$ui->s3_title}}">
                    </div>
                </div>
                <div class="col-lg-5 m-15px-tb">
                    <div class="home-story-card">
                        <span class="home-pill m-20px-b">{{$ui->s2_title}}</span>
                        <h2 class="home-title m-20px-b">{{$ui->s3_title}}</h2>
                        <p class="home-copy m-0px">{{$ui->s3_body}}</p>
                        <div class="home-pillars">
                            <div class="home-pillar">
                                <strong>Entrada</strong>
                                <span>Capte demanda com uma proposta visivelmente mais clara, direta e institucional.</span>
                            </div>
                            <div class="home-pillar">
                                <strong>Controle</strong>
                                <span>Organize cobranca, posicionamento e operacao em uma estrutura mais executiva.</span>
                            </div>
                            <div class="home-pillar">
                                <strong>Escala</strong>
                                <span>{{$lang['front_stimulate_your_sales']}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-section home-section--soft">
        <div class="container">
            <div class="row justify-content-center m-40px-b">
                <div class="col-lg-8 text-center">
                    <span class="home-pill m-20px-b">{{$ui->s1_title}}</span>
                    <h2 class="home-title m-20px-b">Arquitetura visual orientada por capacidades reais</h2>
                    <p class="home-copy m-0px">A home agora prioriza modulos que explicam operacao, monetizacao e confianca sem parecer uma landing page genérica.</p>
                </div>
            </div>
            <div class="row">
                @foreach($item as $val)
                    <div class="col-md-6 col-lg-3 m-15px-tb">
                        <div class="home-capability-card">
                            <div class="home-capability-icon">
                                <i class="fal fa-check-circle"></i>
                            </div>
                            <h5 class="m-15px-b">{{$val->title}}</h5>
                            <p>{{$val->details}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="home-section">
        <div class="container">
            <div class="row justify-content-center m-40px-b">
                <div class="col-lg-8 text-center">
                    <span class="home-pill m-20px-b">estrutura de recebimento</span>
                    <h2 class="home-title m-20px-b">{{$ui->s6_title}}</h2>
                    <p class="home-copy m-0px">{{$ui->s6_body}}</p>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-4 m-15px-tb">
                    <div class="home-rail-card m-15px-b">
                        <div class="home-rail-icon"><i class="fal fa-random"></i></div>
                        <h5 class="m-10px-b">{{$lang['front_transfer_request_money']}}</h5>
                        <p>Transferencias e solicitacoes posicionadas como fluxo central de operacao, nao como recurso paralelo.</p>
                    </div>
                    <div class="home-rail-card">
                        <div class="home-rail-icon"><i class="fal fa-money-bill-wave-alt"></i></div>
                        <h5 class="m-10px-b">{{$lang['front_bill_payment']}}</h5>
                        <p>Recebimento com narrativa mais clara para aproximar cobranca, contexto comercial e conversao.</p>
                    </div>
                </div>
                <div class="col-lg-4 m-15px-tb">
                    <div class="home-rail-visual text-center">
                        <img src="{{url('/')}}/asset/images/{{$ui->s2_image}}" alt="{{$ui->s6_title}}">
                    </div>
                </div>
                <div class="col-lg-4 m-15px-tb">
                    <div class="home-rail-card m-15px-b">
                        <div class="home-rail-icon"><i class="fal fa-envelope"></i></div>
                        <h5 class="m-10px-b">{{$lang['front_invoice_payment']}}</h5>
                        <p>Faturas com leitura mais empresarial, reforcando contexto, legitimidade e previsibilidade.</p>
                    </div>
                    <div class="home-rail-card">
                        <div class="home-rail-icon"><i class="fal fa-credit-card-front"></i></div>
                        <h5 class="m-10px-b">{{$lang['front_virtual_cards']}}</h5>
                        <p>Recursos complementares apresentados como extensao natural da plataforma, com menos dispersao visual.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($reviewCount > 0)
    <section class="home-section home-section--soft">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-5 m-15px-tb">
                    <div class="home-review-visual text-center">
                        <img src="{{url('/')}}/asset/images/{{$ui->s7_image}}" alt="{{$ui->s7_title}}">
                    </div>
                </div>
                <div class="col-lg-6 m-15px-tb">
                    <span class="home-pill m-20px-b">prova social</span>
                    <h2 class="home-title m-20px-b">{{$ui->s7_title}}</h2>
                    <div class="owl-carousel owl-nav-arrow-bottom" data-items="1" data-nav-arrow="true" data-nav-dots="false" data-md-items="1" data-sm-items="1" data-xs-items="1" data-xx-items="1" data-space="20" data-autoplay="true">
                        @foreach($review as $vreview)
                            <div class="home-review-card">
                                <span class="home-review-mark">“</span>
                                <p>{{$vreview->review}}</p>
                                <div class="home-review-person">
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

    <section class="home-section">
        <div class="container">
            <div class="home-cta-card text-center">
                <span class="home-pill m-20px-b">reposicionamento da home</span>
                <h3 class="home-title m-20px-b">{{$lang['front_join_millions_who_choose']}} {{$set->site_name}} {{$lang['front_worldwide']}}</h3>
                <p class="home-copy m-0px">Produto, operacao e credibilidade agora aparecem de forma mais consistente. Se quiser, o proximo passo pode ser especializar a copy para um segmento especifico do seu mercado.</p>
                <div class="home-cta-actions">
                    <a class="m-btn m-btn-radius m-btn-t-dark" href="{{route('register')}}">
                        <span class="m-btn-inner-text">{{$lang['front_sign_up_for_free']}}</span>
                        <span class="m-btn-inner-icon arrow"></span>
                    </a>
                    <a class="m-btn m-btn-radius m-btn-border" href="{{route('contact')}}">
                        <span class="m-btn-inner-text">Entrar em contato</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@stop