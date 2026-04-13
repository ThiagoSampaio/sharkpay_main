@extends('layout')
@section('css')
<style>
    .contact-shell {
        background: linear-gradient(180deg, #f6f7fc 0%, #ffffff 34%, #faf8ff 100%);
    }

    .contact-section {
        padding: 88px 0;
    }

    .contact-hero {
        background:
            radial-gradient(circle at top right, rgba(245, 138, 0, 0.14), transparent 24%),
            linear-gradient(145deg, #12192d 0%, #1f2746 58%, #161d37 100%);
        position: relative;
        overflow: hidden;
    }

    .contact-hero::before {
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

    .contact-hero .container {
        position: relative;
        z-index: 1;
    }

    .contact-pill {
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

    .contact-title {
        color: #fff;
        font-size: 56px;
        line-height: 1.04;
        letter-spacing: -0.05em;
        font-weight: 800;
    }

    .contact-copy {
        color: rgba(255, 255, 255, 0.78);
        font-size: 18px;
        line-height: 1.8;
    }

    .contact-hero-visual img {
        width: 100%;
    }

    .contact-card,
    .contact-info-card {
        position: relative;
        background: #fff;
        border: 1px solid rgba(123, 22, 244, 0.08);
        border-radius: 24px;
        box-shadow: 0 22px 50px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .contact-card::before,
    .contact-info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #5d0fd3 0%, #7b16f4 68%, #f58a00 100%);
    }

    .contact-card,
    .contact-info-card {
        padding: 36px;
    }

    .contact-card h3,
    .contact-info-card h4,
    .contact-info-value {
        color: #1d2542;
        font-weight: 800;
    }

    .contact-body-copy {
        color: #667085;
        line-height: 1.82;
    }

    .contact-card .form-control {
        min-height: 54px;
        border-radius: 16px;
        border-color: #e8e8f2;
        box-shadow: none;
        padding-left: 18px;
    }

    .contact-card textarea.form-control {
        min-height: 140px;
        padding-top: 16px;
    }

    .contact-card .form-control:focus {
        border-color: #7b16f4;
        box-shadow: 0 0 0 4px rgba(123, 22, 244, 0.08);
    }

    .contact-submit {
        box-shadow: 0 14px 28px rgba(123, 22, 244, 0.18);
    }

    .contact-info-row {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 18px 0;
        border-top: 1px solid #eef0f6;
    }

    .contact-info-row:first-of-type {
        border-top: 0;
        padding-top: 0;
    }

    .contact-info-icon {
        width: 52px;
        height: 52px;
        flex: 0 0 52px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        color: #fff;
        font-size: 20px;
        background: linear-gradient(135deg, #5d0fd3 0%, #7b16f4 60%, #f58a00 100%);
    }

    .contact-info-label {
        color: #667085;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 6px;
    }

    .contact-info-value {
        font-size: 22px;
        line-height: 1.35;
    }

    @media (max-width: 991px) {
        .contact-section {
            padding: 70px 0;
        }

        .contact-title {
            font-size: 42px;
        }

        .contact-card,
        .contact-info-card {
            padding: 24px;
        }
    }
</style>
@stop
@section('content')
<div class="contact-shell">
    <section class="contact-section contact-hero">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 m-15px-tb">
                    <span class="contact-pill m-25px-b">
                        <i class="fal fa-headset"></i>
                        {{$set->title}}
                    </span>
                    <h1 class="contact-title m-25px-b">{{$lang['contact_contact_us']}}</h1>
                    <p class="contact-copy m-0px">Canal institucional para conversas comerciais, suporte operacional e duvidas sobre a plataforma, agora com linguagem visual alinhada ao novo posicionamento.</p>
                </div>
                <div class="col-lg-5 m-15px-tb">
                    <div class="contact-hero-visual text-center">
                        <img src="{{url('/')}}/asset/images/section13_1610838957.png" alt="{{$lang['contact_contact_us']}}">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-section pt-0" id="contact">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-lg-7 m-15px-tb">
                    <div class="contact-card">
                        <h3 class="h1 m-15px-b">{{$lang['contact_need_a_hand']}}</h3>
                        <p class="contact-body-copy m-30px-b">{{$lang['contact_we_always_open_and']}}</p>
                        <form class="rd-mailform" method="post" action="{{route('contact-submit')}}">
                            @csrf
                            <div class="form-row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="name" placeholder="{{$lang['contact_rachel_roth']}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="email" name="email" placeholder="name@example.com" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="number" name="mobile" placeholder="12345678987" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea class="form-control" name="message" rows="3" placeholder="{{$lang['contact_hi_there_i_would_like_to']}}"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="m-btn m-btn-dark m-btn-radius contact-submit" type="submit" name="send">{{$lang['contact_get_started']}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5 m-15px-tb">
                    <div class="contact-info-card">
                        <h4 class="m-15px-b">Contato institucional</h4>
                        <p class="contact-body-copy m-25px-b">Informacoes centrais para relacionamento comercial e operacional, apresentadas em um bloco mais objetivo.</p>
                        <div class="contact-info-row">
                            <div class="contact-info-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <div class="contact-info-label">Telefone</div>
                                <div class="contact-info-value">{{$set->mobile}}</div>
                            </div>
                        </div>
                        <div class="contact-info-row">
                            <div class="contact-info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <div class="contact-info-label">E-mail</div>
                                <div class="contact-info-value">{{$set->email}}</div>
                            </div>
                        </div>
                        @if(!empty($set->company_address))
                        <div class="contact-info-row">
                            <div class="contact-info-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <div class="contact-info-label">Endereco</div>
                                <div class="contact-info-value">{{$set->company_address}}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@stop