@extends('layout')
@section('css')
<style>
    .faq-shell {
        background: linear-gradient(180deg, #f6f7fc 0%, #ffffff 34%, #faf8ff 100%);
    }

    .faq-section {
        padding: 88px 0;
    }

    .faq-hero {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(circle at top right, rgba(245, 138, 0, 0.14), transparent 24%),
            linear-gradient(145deg, #12192d 0%, #1f2746 58%, #161d37 100%);
    }

    .faq-hero::before {
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

    .faq-hero .container {
        position: relative;
        z-index: 1;
    }

    .faq-pill {
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

    .faq-title {
        color: #fff;
        font-size: 56px;
        line-height: 1.04;
        letter-spacing: -0.05em;
        font-weight: 800;
    }

    .faq-copy {
        color: rgba(255, 255, 255, 0.78);
        font-size: 18px;
        line-height: 1.8;
    }

    .faq-hero-visual img {
        width: 100%;
    }

    .faq-panel,
    .faq-intro-card {
        position: relative;
        background: #fff;
        border: 1px solid rgba(123, 22, 244, 0.08);
        border-radius: 24px;
        box-shadow: 0 22px 50px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .faq-panel::before,
    .faq-intro-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #5d0fd3 0%, #7b16f4 68%, #f58a00 100%);
    }

    .faq-intro-card,
    .faq-panel {
        padding: 34px;
    }

    .faq-intro-card h3,
    .faq-question,
    .faq-panel .acco-heading {
        color: #1d2542;
        font-weight: 800;
    }

    .faq-intro-card p,
    .faq-answer,
    .faq-panel .acco-des {
        color: #667085;
        line-height: 1.82;
    }

    .faq-feature-list {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        margin-top: 22px;
    }

    .faq-feature-item {
        padding: 18px;
        border-radius: 18px;
        background: #f8f8ff;
        border: 1px solid #ecebfd;
    }

    .faq-feature-item strong {
        display: block;
        color: #1d2542;
        margin-bottom: 6px;
    }

    .faq-feature-item span {
        color: #667085;
        font-size: 14px;
        line-height: 1.7;
    }

    .faq-panel .acco-group {
        border-top: 1px solid #eef0f6;
        padding: 20px 0;
    }

    .faq-panel .acco-group:first-child {
        border-top: 0;
        padding-top: 0;
    }

    .faq-panel .acco-heading {
        display: block;
        padding-right: 32px;
        position: relative;
    }

    .faq-panel .acco-heading::after {
        content: '+';
        position: absolute;
        right: 0;
        top: 0;
        color: #7b16f4;
        font-size: 24px;
        line-height: 1;
        font-weight: 700;
    }

    @media (max-width: 991px) {
        .faq-section {
            padding: 70px 0;
        }

        .faq-title {
            font-size: 42px;
        }

        .faq-feature-list {
            grid-template-columns: 1fr;
        }

        .faq-intro-card,
        .faq-panel {
            padding: 24px;
        }
    }
</style>
@stop
@section('content')
<div class="faq-shell">
    <section class="faq-section faq-hero">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 m-15px-tb">
                    <span class="faq-pill m-25px-b">
                        <i class="fal fa-life-ring"></i>
                        {{$set->title}}
                    </span>
                    <h1 class="faq-title m-25px-b">{{$lang['faq_frequently_asked_question']}}</h1>
                    <p class="faq-copy m-0px">Respostas organizadas com mais clareza para reduzir atrito, acelerar entendimento e reforcar a leitura institucional da plataforma.</p>
                </div>
                <div class="col-lg-5 m-15px-tb">
                    <div class="faq-hero-visual text-center">
                        <img src="{{url('/')}}/asset/images/section14_1610838968.png" alt="{{$lang['faq_frequently_asked_question']}}">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="faq-section pt-0" id="faq">
        <div class="container">
            <div class="row align-items-start justify-content-between">
                <div class="col-lg-4 m-15px-tb">
                    <div class="faq-intro-card">
                        <h3 class="h2 m-15px-b">Base de conhecimento mais objetiva</h3>
                        <p class="m-0px">A FAQ passa a funcionar como um ponto de orientacao institucional, com melhor leitura e enquadramento visual.</p>
                        <div class="faq-feature-list">
                            <div class="faq-feature-item">
                                <strong>Leitura mais clara</strong>
                                <span>Hierarquia visual mais limpa para localizar perguntas e respostas rapidamente.</span>
                            </div>
                            <div class="faq-feature-item">
                                <strong>Tom mais profissional</strong>
                                <span>O visual conversa com a home, Sobre e Contato sem parecer uma tela isolada.</span>
                            </div>
                            <div class="faq-feature-item">
                                <strong>Consistencia de marca</strong>
                                <span>Paleta, espaçamento e acabamento seguem o mesmo sistema visual publico.</span>
                            </div>
                            <div class="faq-feature-item">
                                <strong>Menos ruido</strong>
                                <span>O foco fica na informacao, sem excesso de elementos ou interferencia visual.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 m-15px-tb">
                    <div class="faq-panel accordion accordion-08 p-0 border-radius-15">
                        @foreach($faq as $vfaq)
                        <div class="acco-group">
                            <a href="#" class="acco-heading faq-question">{{$vfaq->question}}</a>
                            <div class="acco-des faq-answer">{!!$vfaq->answer!!}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@stop