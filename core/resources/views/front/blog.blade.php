@extends('layout')
@section('css')
<style>
    .blog-shell {
        background: linear-gradient(180deg, #f6f7fc 0%, #ffffff 34%, #faf8ff 100%);
    }

    .blog-section {
        padding: 88px 0;
    }

    .blog-hero {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(circle at top right, rgba(245, 138, 0, 0.14), transparent 24%),
            linear-gradient(145deg, #12192d 0%, #1f2746 58%, #161d37 100%);
    }

    .blog-hero::before {
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

    .blog-hero .container {
        position: relative;
        z-index: 1;
    }

    .blog-pill {
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

    .blog-title {
        color: #fff;
        font-size: 56px;
        line-height: 1.04;
        letter-spacing: -0.05em;
        font-weight: 800;
    }

    .blog-copy {
        color: rgba(255, 255, 255, 0.78);
        font-size: 18px;
        line-height: 1.8;
    }

    .blog-content-card,
    .blog-card {
        position: relative;
        background: #fff;
        border: 1px solid rgba(123, 22, 244, 0.08);
        border-radius: 24px;
        box-shadow: 0 22px 50px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .blog-content-card::before,
    .blog-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #5d0fd3 0%, #7b16f4 68%, #f58a00 100%);
    }

    .blog-content-card {
        padding: 34px;
    }

    .blog-content-card h3,
    .blog-card h5,
    .blog-card h5 a {
        color: #1d2542;
        font-weight: 800;
    }

    .blog-content-card p,
    .blog-card p {
        color: #667085;
        line-height: 1.82;
    }

    .blog-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 24px;
    }

    .blog-card {
        height: 100%;
    }

    .blog-card__image {
        position: relative;
        overflow: hidden;
    }

    .blog-card__image img {
        width: 100%;
        height: 240px;
        object-fit: cover;
    }

    .blog-card__date {
        position: absolute;
        top: 18px;
        left: 18px;
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: rgba(18, 25, 45, 0.84);
        color: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        line-height: 1;
        backdrop-filter: blur(10px);
    }

    .blog-card__date span {
        display: block;
        margin-top: 6px;
        font-size: 12px;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .blog-card__body {
        padding: 26px;
    }

    .blog-card__link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #5d0fd3;
        font-weight: 700;
    }

    .blog-card__link:hover {
        color: #7b16f4;
    }

    .blog-sidebar-wrap {
        position: relative;
    }

    .blog-sidebar-wrap > * {
        position: relative;
        background: #fff;
        border: 1px solid rgba(123, 22, 244, 0.08);
        border-radius: 24px;
        box-shadow: 0 22px 50px rgba(15, 23, 42, 0.08);
        padding: 26px;
    }

    .blog-sidebar-wrap > *::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #5d0fd3 0%, #7b16f4 68%, #f58a00 100%);
        border-radius: 24px 24px 0 0;
    }

    .blog-pagination {
        margin-top: 28px;
    }

    .blog-pagination .pagination {
        justify-content: center;
    }

    @media (max-width: 991px) {
        .blog-section {
            padding: 70px 0;
        }

        .blog-title {
            font-size: 42px;
        }

        .blog-grid {
            grid-template-columns: 1fr;
        }

        .blog-content-card {
            padding: 24px;
        }
    }
</style>
@stop
@section('content')
<div class="blog-shell">
    <section class="blog-section blog-hero">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-7 m-15px-tb">
                    <span class="blog-pill m-25px-b">
                        <i class="fal fa-newspaper"></i>
                        {{$set->title}}
                    </span>
                    <h1 class="blog-title m-25px-b">{{$title}}</h1>
                    <p class="blog-copy m-0px">Conteudo editorial apresentado com mais consistencia visual, melhor leitura e um enquadramento compatível com o novo posicionamento publico da plataforma.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="blog-section pt-0">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-lg-8 m-15px-tb">
                    <div class="blog-content-card">
                        <h3 class="h2 m-15px-b">Leitura editorial mais clara</h3>
                        <p class="m-0px">A listagem agora destaca cada artigo como um ativo de conteudo com hierarquia mais forte, menos ruido visual e mais coerencia com a identidade institucional do site.</p>
                    </div>
                    <div class="blog-grid m-25px-t">
                        @foreach($posts as $vblog)
                        <div class="blog-card">
                            <div class="blog-card__image">
                                <a href="{{url('/')}}/single/{{$vblog->id}}/{{str_slug($vblog->title)}}">
                                    <img src="{{url('/')}}/asset/thumbnails/{{$vblog->image}}" alt="{{$vblog->title}}">
                                </a>
                                <div class="blog-card__date">
                                    {{date('j', strtotime($vblog->created_at))}}
                                    <span>{{date('M', strtotime($vblog->created_at))}}</span>
                                </div>
                            </div>
                            <div class="blog-card__body">
                                <h5 class="m-15px-b">
                                    <a href="{{url('/')}}/single/{{$vblog->id}}/{{str_slug($vblog->title)}}">{!! str_limit($vblog->title, 58) !!}</a>
                                </h5>
                                <p class="m-20px-b">{!! str_limit(strip_tags($vblog->details), 120) !!}</p>
                                <a class="blog-card__link" href="{{url('/')}}/single/{{$vblog->id}}/{{str_slug($vblog->title)}}">
                                    {{$lang['blog_read_more']}}
                                    <i class="fal fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="blog-pagination">
                        {{$posts->render()}}
                    </div>
                </div>
                <div class="col-lg-4 m-15px-tb blog-sidebar-wrap">
                    @include('partials.sidebar')
                </div>
            </div>
        </div>
    </section>
</div>
@stop