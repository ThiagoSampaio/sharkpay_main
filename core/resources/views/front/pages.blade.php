@extends('layout')
@section('css')
<style>
    .page-shell {
        background: linear-gradient(180deg, #f6f7fc 0%, #ffffff 34%, #faf8ff 100%);
    }

    .page-section {
        padding: 88px 0;
    }

    .page-hero {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(circle at top right, rgba(245, 138, 0, 0.14), transparent 24%),
            linear-gradient(145deg, #12192d 0%, #1f2746 58%, #161d37 100%);
    }

    .page-hero::before {
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

    .page-hero .container {
        position: relative;
        z-index: 1;
    }

    .page-pill {
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

    .page-title {
        color: #fff;
        font-size: 56px;
        line-height: 1.04;
        letter-spacing: -0.05em;
        font-weight: 800;
    }

    .page-copy {
        color: rgba(255, 255, 255, 0.78);
        font-size: 18px;
        line-height: 1.8;
    }

    .page-card {
        position: relative;
        background: #fff;
        border: 1px solid rgba(123, 22, 244, 0.08);
        border-radius: 24px;
        box-shadow: 0 22px 50px rgba(15, 23, 42, 0.08);
        overflow: hidden;
        padding: 40px;
    }

    .page-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #5d0fd3 0%, #7b16f4 68%, #f58a00 100%);
    }

    .page-card,
    .page-card p,
    .page-card li,
    .page-card blockquote {
        color: #667085;
        line-height: 1.9;
    }

    .page-card h1,
    .page-card h2,
    .page-card h3,
    .page-card h4,
    .page-card h5,
    .page-card h6 {
        color: #1d2542;
        font-weight: 800;
        margin-top: 26px;
        margin-bottom: 16px;
    }

    @media (max-width: 991px) {
        .page-section {
            padding: 70px 0;
        }

        .page-title {
            font-size: 42px;
        }

        .page-card {
            padding: 24px;
        }
    }
</style>
@stop
@section('content')
<div class="page-shell">
    <section class="page-section page-hero">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-8 m-15px-tb">
                    <span class="page-pill m-25px-b">
                        <i class="fal fa-file-alt"></i>
                        {{$set->title}}
                    </span>
                    <h1 class="page-title m-25px-b">{{$page->title}}</h1>
                    <p class="page-copy m-0px">Conteudo institucional ou informativo apresentado com o mesmo acabamento visual e a mesma leitura editorial do restante do site publico.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section pt-0">
        <div class="container">
            <div class="page-card">
                {!!$page->content!!}
            </div>
        </div>
    </section>
</div>
@stop