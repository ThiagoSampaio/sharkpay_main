@extends('layout')
@section('css')
<style>
    .article-shell {
        background: linear-gradient(180deg, #f6f7fc 0%, #ffffff 34%, #faf8ff 100%);
    }

    .article-section {
        padding: 88px 0;
    }

    .article-hero {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(circle at top right, rgba(245, 138, 0, 0.14), transparent 24%),
            linear-gradient(145deg, #12192d 0%, #1f2746 58%, #161d37 100%);
    }

    .article-hero::before {
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

    .article-hero .container {
        position: relative;
        z-index: 1;
    }

    .article-pill {
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

    .article-title {
        color: #fff;
        font-size: 54px;
        line-height: 1.05;
        letter-spacing: -0.05em;
        font-weight: 800;
    }

    .article-meta {
        color: rgba(255, 255, 255, 0.74);
        font-size: 15px;
        line-height: 1.8;
    }

    .article-card,
    .article-body-card {
        position: relative;
        background: #fff;
        border: 1px solid rgba(123, 22, 244, 0.08);
        border-radius: 24px;
        box-shadow: 0 22px 50px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .article-card::before,
    .article-body-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #5d0fd3 0%, #7b16f4 68%, #f58a00 100%);
    }

    .article-card {
        padding: 22px;
    }

    .article-card img {
        width: 100%;
        border-radius: 20px;
        object-fit: cover;
    }

    .article-body-card {
        margin-top: 22px;
        padding: 34px;
    }

    .article-body-card,
    .article-body-card p,
    .article-body-card li,
    .article-body-card blockquote {
        color: #667085;
        line-height: 1.9;
    }

    .article-body-card h1,
    .article-body-card h2,
    .article-body-card h3,
    .article-body-card h4,
    .article-body-card h5,
    .article-body-card h6 {
        color: #1d2542;
        font-weight: 800;
        margin-top: 26px;
        margin-bottom: 16px;
    }

    .article-sidebar-wrap > * {
        position: relative;
        background: #fff;
        border: 1px solid rgba(123, 22, 244, 0.08);
        border-radius: 24px;
        box-shadow: 0 22px 50px rgba(15, 23, 42, 0.08);
        padding: 26px;
    }

    .article-sidebar-wrap > *::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #5d0fd3 0%, #7b16f4 68%, #f58a00 100%);
        border-radius: 24px 24px 0 0;
    }

    @media (max-width: 991px) {
        .article-section {
            padding: 70px 0;
        }

        .article-title {
            font-size: 40px;
        }

        .article-body-card {
            padding: 24px;
        }
    }
</style>
@stop
@section('content')
<div class="article-shell">
    <section class="article-section article-hero">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-8 m-15px-tb">
                    <span class="article-pill m-25px-b">
                        <i class="fal fa-pen-nib"></i>
                        {{$set->title}}
                    </span>
                    <h1 class="article-title m-25px-b">{{$post->title}}</h1>
                    <p class="article-meta m-0px">Conteudo editorial com apresentacao mais limpa, leitura mais confortável e melhor coerencia com o posicionamento publico do site.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="article-section pt-0">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-lg-8 m-15px-tb">
                    <div class="article-card">
                        <img src="{{url('/')}}/asset/thumbnails/{{$post->image}}" alt="{{$post->title}}">
                    </div>
                    <div class="article-body-card">
                        {!!$post->details!!}
                    </div>
                </div>
                <div class="col-lg-4 m-15px-tb article-sidebar-wrap">
                    @include('partials.sidebar')
                </div>
            </div>
        </div>
    </section>
</div>
@stop