<style>
    .public-sidebar {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .public-sidebar-card {
        position: relative;
        background: #fff;
        border: 1px solid rgba(123, 22, 244, 0.08);
        border-radius: 24px;
        box-shadow: 0 22px 50px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .public-sidebar-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #5d0fd3 0%, #7b16f4 68%, #f58a00 100%);
    }

    .public-sidebar-card__header {
        padding: 24px 24px 18px;
    }

    .public-sidebar-card__header span {
        color: #1d2542;
        font-size: 18px;
        font-weight: 800;
    }

    .public-sidebar-list {
        padding: 0 16px 16px;
    }

    .public-sidebar-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 16px;
        border-radius: 18px;
        color: #667085;
        transition: .25s ease;
    }

    .public-sidebar-link:hover {
        background: #f8f8ff;
        color: #5d0fd3;
    }

    .public-sidebar-link + .public-sidebar-link {
        margin-top: 8px;
    }

    .public-sidebar-thumb {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        object-fit: cover;
        flex: 0 0 58px;
    }

    .public-sidebar-title {
        color: #1d2542;
        font-weight: 700;
        line-height: 1.5;
    }
</style>
<div class="col-lg-4 lg-m-30px-tb">
    <div class="public-sidebar">
        <div class="public-sidebar-card">
            <div class="public-sidebar-card__header">
                <span>{{$lang['sidebar_categories']}}</span>
            </div>
            <div class="public-sidebar-list">
                @foreach($cat as $vcat)
                    @php
                        $cslug=str_slug($vcat->categories);
                        $rate=count(DB::select('select * from trending where cat_id=? and status=?', [$vcat->id,1]));
                    @endphp
                    <a href="{{url('/')}}/cat/{{$vcat->id}}/{{$cslug}}" class="public-sidebar-link">
                        <div>
                            <span class="public-sidebar-title">{{$vcat->categories}}</span>
                        </div>
                        <div>
                            <i class="ti-angle-right"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="public-sidebar-card">
            <div class="public-sidebar-card__header">
                <span>{{$lang['sidebar_recent_posts']}}</span>
            </div>
            <div class="public-sidebar-list">
                @foreach($trending as $vtrending)
                    @php $vslug=str_slug($vtrending->title); @endphp
                    <a href="{{url('/')}}/single/{{$vtrending->id}}/{{$vslug}}" class="public-sidebar-link">
                        <div>
                            <img class="public-sidebar-thumb" src="{{url('/')}}/asset/thumbnails/{{$vtrending->image}}" alt="{{$vtrending->title}}">
                        </div>
                        <div class="p-15px-l">
                            <p class="m-0px public-sidebar-title">{{$vtrending->title}}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>