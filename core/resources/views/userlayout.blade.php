<!doctype html>
<html class="no-js" lang="en">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <base href="{{url('/')}}"/>
        <title>{{ $title ?? 'Dashboard' }} | {{$set->site_name}}</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
        <meta name="robots" content="index, follow">
        <meta name="apple-mobile-web-app-title" content="{{$set->site_name}}"/>
        <meta name="application-name" content="{{$set->site_name}}"/>
        <meta name="msapplication-TileColor" content="#ffffff"/>
        <meta name="description" content="{{$set->site_desc}}" />
        <link rel="shortcut icon" href="{{url('/')}}/asset/{{$logo->image_link2}}" />
        <!--<link rel="stylesheet" href="{{url('/')}}/asset/css/sweetalert.css" type="text/css">-->
        <link rel="stylesheet" href="{{url('/')}}/asset/css/toast.css" type="text/css">
        <!-- <link rel="stylesheet" href="{{url('/')}}/asset/dashboard/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css"> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="{{url('/')}}/asset/dashboard/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="{{url('/')}}/asset/dashboard/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">
        <link rel="stylesheet" href="{{url('/')}}/asset/dashboard/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="{{url('/')}}/asset/dashboard/css/argon.css?v=1.1.0" type="text/css">
        <link rel="stylesheet" href="{{url('/')}}/asset/dashboard/css/custom-modern.css" type="text/css">
        <link rel="stylesheet" href="{{url('/')}}/asset/dashboard/css/product-modern.css" type="text/css">
        <link rel="stylesheet" href="{{url('/')}}/asset/dashboard/css/sidebar-fixed.css" type="text/css">
        <!-- Lucide Icons -->
        <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.css">
        <link rel="stylesheet" href="{{url('/')}}/asset/css/sweetalert.css" type="text/css">
        <link rel="stylesheet" href="{{url('/')}}/asset/dashboard/vendor/select2/dist/css/select2.min.css">
        <link href="{{url('/')}}/asset/fonts/fontawesome/css/all.css" rel="stylesheet" type="text/css">
        <!-- Bootstrap Icons CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

         @yield('css')
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
            --sharkpay-surface-soft: #fafbfe;
          }

          body.sharkpay-panel {
            background: linear-gradient(180deg, #f7f8fc 0%, #f3f5fa 100%);
            color: var(--sharkpay-ink);
          }

          body.sharkpay-panel .container-fluid.mt--6 {
            padding-top: 5.75rem;
            padding-bottom: 1.5rem;
          }

          body.sharkpay-panel .content-wrapper {
            padding: 0 1rem 2rem;
          }

          body.sharkpay-panel .panel-page-stack {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
          }

          body.sharkpay-panel .panel-page-hero {
            position: relative;
            overflow: hidden;
            padding: 1.45rem 1.5rem;
            border: 1px solid rgba(123, 22, 244, 0.08);
            border-radius: 24px;
            background:
              radial-gradient(circle at top right, rgba(255,255,255,.8), transparent 28%),
              linear-gradient(135deg, rgba(123, 22, 244, 0.09), rgba(245, 138, 0, 0.08));
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.05);
          }

          body.sharkpay-panel .panel-page-hero::after {
            content: "";
            position: absolute;
            right: -50px;
            bottom: -70px;
            width: 170px;
            height: 170px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(123, 22, 244, 0.12), transparent 68%);
          }

          body.sharkpay-panel .panel-page-hero > * {
            position: relative;
            z-index: 1;
          }

          body.sharkpay-panel .panel-page-hero__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .38rem .78rem;
            border-radius: 999px;
            background: rgba(255,255,255,.72);
            color: var(--sharkpay-purple-dark);
            font-size: .74rem;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
          }

          body.sharkpay-panel .panel-page-hero__title {
            margin: .9rem 0 .45rem;
            color: var(--sharkpay-ink);
            font-size: 1.9rem;
            font-weight: 800;
            letter-spacing: -.03em;
            line-height: 1.15;
          }

          body.sharkpay-panel .panel-page-hero__copy {
            max-width: 840px;
            margin: 0;
            color: var(--sharkpay-slate);
            line-height: 1.75;
          }

          body.sharkpay-panel .panel-page-hero__actions {
            display: flex;
            flex-wrap: wrap;
            gap: .75rem;
            margin-top: 1rem;
          }

          body.sharkpay-panel .panel-page-hero__meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: .8rem;
            margin-top: 1rem;
          }

          body.sharkpay-panel .panel-page-meta-card {
            padding: .95rem 1rem;
            border-radius: 18px;
            background: rgba(255,255,255,.74);
            border: 1px solid rgba(123, 22, 244, 0.08);
            backdrop-filter: blur(8px);
          }

          body.sharkpay-panel .panel-page-meta-card span {
            display: block;
            color: #8b92a7;
            font-size: .7rem;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
          }

          body.sharkpay-panel .panel-page-meta-card strong {
            display: block;
            margin-top: .3rem;
            color: var(--sharkpay-ink);
            font-size: 1rem;
            font-weight: 800;
          }

          body.sharkpay-panel .panel-summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: .9rem;
          }

          body.sharkpay-panel .panel-summary-card {
            padding: 1rem 1.05rem;
            border-radius: 20px;
            background: #fff;
            border: 1px solid rgba(17, 24, 39, 0.06);
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
          }

          body.sharkpay-panel .panel-summary-card__label {
            display: block;
            color: #8b92a7;
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
          }

          body.sharkpay-panel .panel-summary-card__value {
            display: block;
            margin-top: .35rem;
            color: var(--sharkpay-ink);
            font-size: 1.35rem;
            font-weight: 800;
            line-height: 1.15;
          }

          body.sharkpay-panel .panel-summary-card__hint {
            display: block;
            margin-top: .28rem;
            color: var(--sharkpay-slate);
            font-size: .8rem;
          }

          body.sharkpay-panel .panel-note {
            display: flex;
            align-items: flex-start;
            gap: .75rem;
            padding: .95rem 1rem;
            border-radius: 18px;
            border: 1px solid rgba(123, 22, 244, 0.08);
            background: #fbf9ff;
            color: var(--sharkpay-ink);
          }

          body.sharkpay-panel .panel-note i,
          body.sharkpay-panel .panel-note svg {
            color: var(--sharkpay-orange);
            flex: 0 0 auto;
          }

          body.sharkpay-panel .panel-note strong {
            display: block;
            margin-bottom: .2rem;
            font-size: .92rem;
          }

          body.sharkpay-panel .panel-note p {
            margin: 0;
            color: var(--sharkpay-slate);
            font-size: .88rem;
            line-height: 1.65;
          }

          body.sharkpay-panel .header.pb-6,
          body.sharkpay-panel .header.pb-5,
          body.sharkpay-panel .header.pb-4 {
            margin: 0 1rem 1rem;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            background: transparent !important;
          }

          body.sharkpay-panel .header .container-fluid {
            padding-left: 0;
            padding-right: 0;
          }

          body.sharkpay-panel .header-body {
            min-height: auto;
            padding: 1.2rem 1.25rem;
            border: 1px solid rgba(17, 24, 39, 0.06);
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.92);
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
            backdrop-filter: blur(10px);
          }

          body.sharkpay-panel .header-body.text-center,
          body.sharkpay-panel .header-body.text-center.mb-7 {
            padding: 1.65rem 1.4rem;
            margin-bottom: 1rem !important;
          }

          body.sharkpay-panel .header-body .row.align-items-center.py-4 {
            margin: 0;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
          }

          body.sharkpay-panel .header-body h6.h2,
          body.sharkpay-panel .header-body .h2,
          body.sharkpay-panel .header-body h2,
          body.sharkpay-panel .header-body h1 {
            margin-bottom: .35rem;
            color: var(--sharkpay-ink);
            font-weight: 800;
            letter-spacing: -.02em;
          }

          body.sharkpay-panel .header-body .text-sm,
          body.sharkpay-panel .header-body p,
          body.sharkpay-panel .header-body .mb-0.text-sm {
            color: var(--sharkpay-slate);
          }

          body.sharkpay-panel .breadcrumb {
            margin: 0;
            padding: .3rem .45rem;
            border-radius: 999px;
            background: #f8f7fc;
          }

          body.sharkpay-panel .breadcrumb-item,
          body.sharkpay-panel .breadcrumb-item a {
            color: #8b92a7;
            font-size: .78rem;
            font-weight: 700;
          }

          body.sharkpay-panel .breadcrumb-item.active {
            color: var(--sharkpay-purple-dark);
          }

          body.sharkpay-panel .breadcrumb-item + .breadcrumb-item::before {
            color: #c0c6d4;
          }

          body.sharkpay-panel .alert {
            display: flex;
            align-items: flex-start;
            gap: .8rem;
            padding: 1rem 1.1rem;
            border-radius: 18px;
            border-width: 1px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
          }

          body.sharkpay-panel .alert .close {
            opacity: .6;
          }

          body.sharkpay-panel .alert-inner--icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 12px;
            background: rgba(255,255,255,.55);
            flex: 0 0 auto;
          }

          body.sharkpay-panel .alert-inner--text {
            padding-top: .2rem;
            font-weight: 600;
          }

          body.sharkpay-panel i[class*="fa"],
          body.sharkpay-panel .btn i,
          body.sharkpay-panel .badge i,
          body.sharkpay-panel .nav-link i {
            width: 1rem;
            text-align: center;
          }

          body.sharkpay-panel .nav-link i {
            font-size: 1rem !important;
          }

          body.sharkpay-panel .mobile-menu-toggle {
            top: 1rem;
            left: 1rem;
            width: 42px;
            height: 42px;
            border: 0;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--sharkpay-purple-dark), var(--sharkpay-purple));
            color: #fff;
            box-shadow: 0 12px 24px rgba(123, 22, 244, 0.16);
          }

          body.sharkpay-panel .mobile-overlay.show {
            backdrop-filter: blur(3px);
          }

          body.sharkpay-panel .sidenav {
            background: #fff !important;
            border-right: 1px solid rgba(17, 24, 39, 0.06);
            box-shadow: 16px 0 36px rgba(15, 23, 42, 0.05);
            overflow: hidden;
          }

          body.sharkpay-panel .sidenav .sidebar-scroll-area {
            position: relative;
            z-index: 1;
            padding-bottom: 2rem;
            height: 100%;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            scrollbar-width: thin;
            scrollbar-color: #b8bfcc #eef1f5;
          }

          body.sharkpay-panel .sidenav .sidebar-scroll-area::-webkit-scrollbar {
            width: 8px;
          }

          body.sharkpay-panel .sidenav .sidebar-scroll-area::-webkit-scrollbar-track {
            background: #eef1f5;
            border-radius: 999px;
          }

          body.sharkpay-panel .sidenav .sidebar-scroll-area::-webkit-scrollbar-thumb {
            background: #b8bfcc;
            border-radius: 999px;
          }

          body.sharkpay-panel .sidenav .sidebar-scroll-area::-webkit-scrollbar-thumb:hover {
            background: #9ea7b5;
          }

          body.sharkpay-panel .sidenav .sidebar-scroll-area > .scroll-element,
          body.sharkpay-panel .sidenav .sidebar-scroll-area > .scroll-element.scroll-y,
          body.sharkpay-panel .sidenav .sidebar-scroll-area > .scroll-element.scroll-x {
            display: none !important;
            opacity: 0 !important;
            pointer-events: none !important;
          }

          body.sharkpay-panel .sidenav .navbar-collapse {
            overflow: visible !important;
          }

          body.sharkpay-panel .sidenav-header {
            display: block !important;
            height: auto !important;
            min-height: 0 !important;
            padding: 1.25rem 1rem 1rem;
            margin-bottom: .5rem;
            pointer-events: auto;
            text-align: center;
          }

          body.sharkpay-panel .navbar-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: auto;
            margin: 0 auto;
            padding: 0;
            border-radius: 0;
            background: transparent;
            border: 0;
            box-shadow: none;
          }

          body.sharkpay-panel .navbar-brand-img {
            display: block;
            max-height: 54px !important;
            width: auto;
            margin: 0 auto;
          }

          body.sharkpay-panel .sidebar-account-card {
            display: grid;
            grid-template-columns: 38px minmax(0, 1fr);
            gap: .65rem;
            align-items: center;
            margin-top: .85rem;
            padding: .7rem;
            border-radius: 16px;
            background: #fff;
            border: 1px solid var(--sharkpay-border);
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.04);
          }

          body.sharkpay-panel .sidebar-account-card__avatar {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 0 0 3px rgba(123, 22, 244, 0.08);
          }

          body.sharkpay-panel .sidebar-account-card__meta {
            min-width: 0;
          }

          body.sharkpay-panel .sidebar-account-card__eyebrow {
            display: block;
            margin-bottom: .15rem;
            color: #8e6ccb;
            font-size: .58rem;
            font-weight: 800;
            letter-spacing: .1em;
            text-transform: uppercase;
          }

          body.sharkpay-panel .sidebar-account-card__name {
            display: block;
            color: var(--sharkpay-ink);
            font-size: .84rem;
            font-weight: 800;
            line-height: 1.3;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
          }

          body.sharkpay-panel .sidebar-account-card__subtext {
            display: block;
            margin-top: .08rem;
            color: var(--sharkpay-slate);
            font-size: .68rem;
            line-height: 1.35;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
          }

          body.sharkpay-panel .sidebar-account-card__chips {
            display: flex;
            flex-wrap: wrap;
            gap: .28rem;
            margin-top: .45rem;
          }

          body.sharkpay-panel .sidebar-account-chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 1.35rem;
            padding: 0 .42rem;
            border-radius: 999px;
            background: #f7f4ff;
            border: 1px solid rgba(123, 22, 244, 0.08);
            color: var(--sharkpay-purple-dark);
            font-size: .56rem;
            font-weight: 800;
            letter-spacing: .04em;
            line-height: 1.1;
            text-align: center;
          }

          body.sharkpay-panel .sidebar-account-chip--warning {
            background: #fff7eb;
            border-color: rgba(245, 138, 0, 0.16);
            color: #c06c00;
          }

          body.sharkpay-panel .sidebar-account-chip--success {
            background: #eefbf5;
            border-color: rgba(16, 185, 129, 0.14);
            color: #0d8b61;
          }

          body.sharkpay-panel .navbar-heading {
            display: flex;
            align-items: center;
            gap: .55rem;
            margin: 1.2rem 1rem .7rem !important;
            color: #8b92a7 !important;
            font-size: .7rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
          }

          body.sharkpay-panel .navbar-heading::before {
            content: "";
            width: .42rem;
            height: .42rem;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--sharkpay-purple), var(--sharkpay-orange));
            flex: 0 0 auto;
          }

          body.sharkpay-panel .sidenav .navbar-nav {
            padding: 0 .75rem;
          }

          body.sharkpay-panel .navbar-inner {
            padding-top: .2rem;
          }

          body.sharkpay-panel .sidenav .nav-item {
            margin-bottom: .25rem;
          }

          body.sharkpay-panel .sidenav .nav-link {
            display: grid;
            grid-template-columns: 20px minmax(0, 1fr) auto;
            align-items: center;
            gap: .8rem;
            min-height: 46px;
            padding: .72rem .85rem;
            margin-bottom: 0;
            border: 1px solid transparent;
            border-radius: 14px;
            color: #5e667b !important;
            position: relative;
            box-shadow: none;
            transition: background-color .18s ease, border-color .18s ease, color .18s ease;
          }

          body.sharkpay-panel .sidenav .nav-link:hover {
            background: #f7f7fb;
            border-color: rgba(17, 24, 39, 0.05);
            color: var(--sharkpay-purple-dark) !important;
            transform: none;
          }

          body.sharkpay-panel .sidenav .nav-link.active,
          body.sharkpay-panel .sidenav .nav-item.active > .nav-link {
            background: linear-gradient(135deg, rgba(123, 22, 244, 0.11), rgba(245, 138, 0, 0.08));
            border-color: rgba(123, 22, 244, 0.14);
            color: var(--sharkpay-purple-dark) !important;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.3);
          }

          body.sharkpay-panel .sidenav .nav-link.active::before,
          body.sharkpay-panel .sidenav .nav-item.active > .nav-link::before {
            content: "";
            position: absolute;
            left: .45rem;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 20px;
            border-radius: 999px;
            background: linear-gradient(180deg, var(--sharkpay-purple-dark), var(--sharkpay-orange));
          }

          body.sharkpay-panel .sidenav .nav-link i,
          body.sharkpay-panel .sidenav .nav-link svg {
            color: #8a49f2;
            flex: 0 0 auto;
            width: 20px;
            text-align: center;
          }

          body.sharkpay-panel .sidenav .nav-link:hover i,
          body.sharkpay-panel .sidenav .nav-link:hover svg,
          body.sharkpay-panel .sidenav .nav-link.active i,
          body.sharkpay-panel .sidenav .nav-link.active svg,
          body.sharkpay-panel .sidenav .nav-item.active > .nav-link i,
          body.sharkpay-panel .sidenav .nav-item.active > .nav-link svg {
            color: var(--sharkpay-orange) !important;
          }

          body.sharkpay-panel .sidenav .nav-link:hover svg,
          body.sharkpay-panel .sidenav .nav-link.active svg,
          body.sharkpay-panel .sidenav .nav-item.active > .nav-link svg,
          body.sharkpay-panel .sidenav .nav-link:hover svg *,
          body.sharkpay-panel .sidenav .nav-link.active svg *,
          body.sharkpay-panel .sidenav .nav-item.active > .nav-link svg * {
            stroke: var(--sharkpay-orange) !important;
          }

          body.sharkpay-panel .sidenav .nav-link-text {
            display: block;
            min-width: 0;
            font-size: .89rem;
            font-weight: 700;
            line-height: 1.35;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
          }

          body.sharkpay-panel .sidenav .nav-sm {
            margin: .3rem 0 .15rem;
            padding-left: .6rem;
            border-left: 1px solid rgba(17, 24, 39, 0.06);
          }

          body.sharkpay-panel .sidenav .nav-sm .nav-item {
            margin-bottom: .2rem;
          }

          body.sharkpay-panel .sidenav .nav-sm .nav-link {
            min-height: 40px;
            margin-left: .2rem;
            padding: .55rem .75rem;
            border-radius: 12px;
            border-color: transparent;
            color: #6f7892 !important;
            font-size: .84rem;
            font-weight: 600;
          }

          body.sharkpay-panel .sidenav .nav-sm .nav-link.active,
          body.sharkpay-panel .sidenav .nav-sm .nav-item.active > .nav-link {
            background: #f4efff;
            border-color: rgba(123, 22, 244, 0.12);
            color: var(--sharkpay-purple-dark) !important;
          }

          body.sharkpay-panel .sidenav .nav-sm .nav-link.active::before,
          body.sharkpay-panel .sidenav .nav-sm .nav-item.active > .nav-link::before {
            left: .35rem;
            width: 2px;
            height: 16px;
          }

          body.sharkpay-panel .sidenav .badge-floating {
            position: static;
            transform: none;
            margin-left: 0;
            min-width: 20px;
            height: 20px;
            padding: 0 .35rem;
            border: 0 !important;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--sharkpay-purple-dark), var(--sharkpay-purple));
            color: #fff;
            font-size: .64rem;
            font-weight: 800;
            line-height: 20px;
            text-align: center;
            box-shadow: none;
          }

          body.sharkpay-panel .sidenav .nav-link.active .badge-floating,
          body.sharkpay-panel .sidenav .nav-item.active > .nav-link .badge-floating {
            background: linear-gradient(135deg, var(--sharkpay-orange), #ffb54f);
          }

          body.sharkpay-panel .navbar-top {
            margin: 1rem 1rem 0;
            padding: .95rem 1.1rem;
            border: 1px solid rgba(17, 24, 39, 0.06);
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
          }

          body.sharkpay-panel .dashboard-search {
            max-width: 460px;
            width: 100%;
          }

          body.sharkpay-panel .dashboard-search .input-group {
            overflow: hidden;
            border: 1px solid var(--sharkpay-border);
            border-radius: 14px;
            background: var(--sharkpay-surface-soft);
          }

          body.sharkpay-panel .dashboard-search .input-group-text,
          body.sharkpay-panel .dashboard-search .form-control {
            background: transparent;
            border: 0;
            box-shadow: none;
          }

          body.sharkpay-panel .dashboard-search .form-control {
            color: var(--sharkpay-ink);
          }

          body.sharkpay-panel .dashboard-search .form-control::placeholder {
            color: #98a2b3;
          }

          body.sharkpay-panel .dashboard-balance-chip {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            margin: 0;
            padding: .68rem .95rem;
            border-radius: 999px;
            background: linear-gradient(135deg, #f7f2ff, #fff8f0);
            border: 1px solid rgba(123, 22, 244, 0.1);
            color: var(--sharkpay-purple-dark) !important;
            font-size: .95rem;
            box-shadow: none;
          }

          body.sharkpay-panel .dashboard-balance-chip i,
          body.sharkpay-panel .dashboard-balance-chip svg {
            color: var(--sharkpay-orange);
          }

          body.sharkpay-panel .dashboard-profile-link,
          body.sharkpay-panel .dashboard-profile-toggle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 44px;
            min-height: 44px;
            border-radius: 14px;
            border: 1px solid rgba(17, 24, 39, 0.06);
            background: #fff;
            box-shadow: none;
          }

          body.sharkpay-panel .dashboard-profile-toggle {
            padding: 0 .85rem;
          }

          body.sharkpay-panel .avatar {
            box-shadow: 0 0 0 3px rgba(123, 22, 244, 0.08);
          }

          body.sharkpay-panel .dropdown-menu {
            border: 1px solid rgba(17, 24, 39, 0.06);
            border-radius: 16px;
            box-shadow: 0 18px 28px rgba(15, 23, 42, 0.08);
            padding: .55rem;
          }

          body.sharkpay-panel .dropdown-item {
            display: flex;
            align-items: center;
            gap: .7rem;
            border-radius: 12px;
            padding: .72rem .85rem;
            color: var(--sharkpay-ink);
            font-weight: 600;
          }

          body.sharkpay-panel .dropdown-item:hover {
            background: var(--sharkpay-purple-soft);
            color: var(--sharkpay-purple-dark);
          }

          body.sharkpay-panel .nav-wrapper {
            padding: .45rem;
            border: 1px solid rgba(17, 24, 39, 0.06);
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.88);
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
          }

          body.sharkpay-panel .nav-pills {
            gap: .5rem;
          }

          body.sharkpay-panel .nav-pills .nav-item {
            margin: 0;
          }

          body.sharkpay-panel .nav-pills .nav-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .6rem;
            min-height: 44px;
            padding: .72rem 1rem;
            border-radius: 14px;
            background: transparent;
            color: #667085;
            font-size: .88rem;
            font-weight: 700;
            border: 1px solid transparent;
          }

          body.sharkpay-panel .nav-pills .nav-link.active,
          body.sharkpay-panel .nav-pills .show > .nav-link {
            background: linear-gradient(135deg, rgba(123, 22, 244, 0.12), rgba(245, 138, 0, 0.08));
            border-color: rgba(123, 22, 244, 0.14);
            color: var(--sharkpay-purple-dark);
            box-shadow: none;
          }

          body.sharkpay-panel .nav-pills .nav-link:hover {
            background: #f8f7fc;
            color: var(--sharkpay-purple-dark);
          }

          body.sharkpay-panel .card {
            overflow: hidden;
            border-radius: 20px;
            background: #fff;
          }

          body.sharkpay-panel .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem 1.25rem;
            background: linear-gradient(180deg, #ffffff 0%, #fcfcff 100%);
            border-bottom: 1px solid rgba(17, 24, 39, 0.06);
          }

          body.sharkpay-panel .card-body {
            padding: 1.25rem;
          }

          body.sharkpay-panel .h2,
          body.sharkpay-panel .h3,
          body.sharkpay-panel h2,
          body.sharkpay-panel h3,
          body.sharkpay-panel h4,
          body.sharkpay-panel .font-weight-bolder {
            color: var(--sharkpay-ink);
          }

          body.sharkpay-panel .text-default,
          body.sharkpay-panel .text-sm,
          body.sharkpay-panel .card-text,
          body.sharkpay-panel p {
            color: var(--sharkpay-slate);
          }

          body.sharkpay-panel .btn {
            border-radius: 14px;
            font-weight: 700;
            letter-spacing: .01em;
            box-shadow: none;
            border-width: 1px;
          }

          body.sharkpay-panel .btn-sm {
            min-height: 38px;
            padding: .52rem .9rem;
          }

          body.sharkpay-panel .btn-block {
            min-height: 44px;
          }

          body.sharkpay-panel .btn-neutral,
          body.sharkpay-panel .btn-light {
            background: linear-gradient(135deg, var(--sharkpay-purple-dark), var(--sharkpay-purple));
            border-color: transparent;
            color: #fff;
          }

          body.sharkpay-panel .btn-neutral:hover,
          body.sharkpay-panel .btn-light:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(123, 22, 244, 0.18);
          }

          body.sharkpay-panel .btn-primary {
            background: linear-gradient(135deg, var(--sharkpay-purple-dark), var(--sharkpay-purple));
            border-color: transparent;
          }

          body.sharkpay-panel .btn-outline-primary {
            background: #fff;
            color: var(--sharkpay-purple-dark);
            border-color: rgba(123, 22, 244, 0.14);
          }

          body.sharkpay-panel .btn-outline-primary:hover,
          body.sharkpay-panel .btn-outline-primary.active,
          body.sharkpay-panel .btn-outline-primary:active {
            background: #f6f2ff;
            color: var(--sharkpay-purple-dark);
            border-color: rgba(123, 22, 244, 0.22);
            box-shadow: none;
          }

          body.sharkpay-panel .btn-danger {
            background: #fff5f5;
            color: #d92d20;
            border-color: #f4c7c3;
          }

          body.sharkpay-panel .btn-danger:hover {
            background: #ffe9e8;
            color: #b42318;
          }

          body.sharkpay-panel .btn-info,
          body.sharkpay-panel .btn-success {
            border-color: transparent;
          }

          body.sharkpay-panel .form-control,
          body.sharkpay-panel .custom-select,
          body.sharkpay-panel textarea.form-control,
          body.sharkpay-panel .custom-file-label,
          body.sharkpay-panel .select2-selection,
          body.sharkpay-panel .input-group-text {
            min-height: 44px;
            border-radius: 14px;
            border-color: var(--sharkpay-border) !important;
            background: #fbfcff;
            color: var(--sharkpay-ink);
            box-shadow: none !important;
          }

          body.sharkpay-panel .form-control:focus,
          body.sharkpay-panel .custom-file-input:focus ~ .custom-file-label,
          body.sharkpay-panel .select2-container--default.select2-container--focus .select2-selection--single,
          body.sharkpay-panel .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: rgba(123, 22, 244, 0.28) !important;
            box-shadow: 0 0 0 4px rgba(123, 22, 244, 0.08) !important;
            background: #fff;
          }

          body.sharkpay-panel .input-group {
            align-items: stretch;
          }

          body.sharkpay-panel .input-group .form-control {
            border-left: 0;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
          }

          body.sharkpay-panel .input-group-prepend .input-group-text,
          body.sharkpay-panel .input-group-append .input-group-text {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            background: #f8f9fd;
            color: #8b92a7;
          }

          body.sharkpay-panel .custom-file-label::after {
            height: calc(100% - 8px);
            margin: 4px;
            border-radius: 10px;
            background: #f2f4f7;
            color: var(--sharkpay-purple-dark);
          }

          body.sharkpay-panel .form-group,
          body.sharkpay-panel .form-group.row {
            margin-bottom: 1rem;
          }

          body.sharkpay-panel .form-group.row {
            align-items: center;
          }

          body.sharkpay-panel .form-group.row > [class*="col-"] {
            margin-bottom: 0;
          }

          body.sharkpay-panel .col-form-label,
          body.sharkpay-panel label {
            color: var(--sharkpay-ink);
            font-weight: 700;
          }

          body.sharkpay-panel .table-responsive {
            padding: 1rem 1.1rem 1.15rem !important;
          }

          body.sharkpay-panel .card .table-responsive.py-4,
          body.sharkpay-panel .card .table-responsive.py-3 {
            padding-top: .5rem !important;
          }

          body.sharkpay-panel .table {
            margin-bottom: 0;
            background: transparent;
          }

          body.sharkpay-panel .table thead th {
            border-top: 0;
            border-bottom: 1px solid rgba(17, 24, 39, 0.08);
            color: #8b92a7;
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: .9rem .85rem;
            background: #fbfbfe;
          }

          body.sharkpay-panel .table td {
            border-top: 0;
            border-bottom: 1px solid rgba(17, 24, 39, 0.05);
            padding: .95rem .85rem;
            vertical-align: middle;
            color: var(--sharkpay-ink);
            font-size: .9rem;
          }

          body.sharkpay-panel .table tbody tr:hover {
            background: #fcfbff;
          }

          body.sharkpay-panel .table thead.thead-light th,
          body.sharkpay-panel .thead-light th {
            background: #fbfbfe;
            color: #8b92a7;
            border-color: rgba(17, 24, 39, 0.08);
          }

          body.sharkpay-panel .table.align-items-center td,
          body.sharkpay-panel .table.align-items-center th {
            vertical-align: middle;
          }

          body.sharkpay-panel .table .media {
            align-items: center;
          }

          body.sharkpay-panel .table .avatar {
            width: 40px;
            height: 40px;
          }

          body.sharkpay-panel .badge,
          body.sharkpay-panel .badge-pill {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            min-height: 28px;
            padding: .35rem .7rem;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .02em;
            border: 1px solid transparent;
          }

          body.sharkpay-panel .badge-success {
            background: #eefbf5;
            border-color: rgba(16, 185, 129, 0.14);
            color: #0d8b61;
          }

          body.sharkpay-panel .badge-danger {
            background: #fff3f2;
            border-color: rgba(217, 45, 32, 0.14);
            color: #d92d20;
          }

          body.sharkpay-panel .badge-warning {
            background: #fff7eb;
            border-color: rgba(245, 138, 0, 0.14);
            color: #c06c00;
          }

          body.sharkpay-panel .badge-info,
          body.sharkpay-panel .badge-primary {
            background: #f3edff;
            border-color: rgba(123, 22, 244, 0.12);
            color: var(--sharkpay-purple-dark);
          }

          body.sharkpay-panel .modal-content {
            border-radius: 20px;
          }

          body.sharkpay-panel .modal-header {
            border-bottom-color: rgba(17, 24, 39, 0.06);
          }

          body.sharkpay-panel .modal-footer {
            border-top-color: rgba(17, 24, 39, 0.06);
          }

          body.sharkpay-panel .list-group-item {
            border-color: rgba(17, 24, 39, 0.06);
            color: var(--sharkpay-ink);
          }

          body.sharkpay-panel .nav-tabs {
            border-bottom: 1px solid rgba(17, 24, 39, 0.08);
          }

          body.sharkpay-panel .nav-tabs .nav-link {
            border: 0;
            border-bottom: 2px solid transparent;
            color: #8b92a7;
            font-weight: 700;
          }

          body.sharkpay-panel .nav-tabs .nav-link.active,
          body.sharkpay-panel .nav-tabs .nav-item.show .nav-link {
            color: var(--sharkpay-purple-dark);
            border-bottom-color: var(--sharkpay-orange);
            background: transparent;
          }

          body.sharkpay-panel .text-right .btn,
          body.sharkpay-panel .col-5.text-right .btn,
          body.sharkpay-panel .col-lg-4.col-5.text-right .btn,
          body.sharkpay-panel .col-lg-6.text-right .btn {
            margin-bottom: .35rem;
          }

          body.sharkpay-panel .row.align-items-center.py-4 + .row,
          body.sharkpay-panel .header-body + .row {
            margin-top: 0;
          }

          body.sharkpay-panel .card-header.border-0 {
            border-bottom: 1px solid rgba(17, 24, 39, 0.06) !important;
          }

          body.sharkpay-panel .card-header .row.align-items-center {
            width: 100%;
            margin: 0;
          }

          body.sharkpay-panel .card-header .col.text-right .btn,
          body.sharkpay-panel .card-header .col-auto .btn {
            margin-bottom: 0;
          }

          body.sharkpay-panel .empty-state,
          body.sharkpay-panel .text-center.mt-8 {
            padding: 2.2rem 1rem;
            border: 1px dashed rgba(123, 22, 244, 0.14);
            border-radius: 20px;
            background: rgba(255,255,255,0.72);
          }

          body.sharkpay-panel .empty-state-illustration {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 84px;
            height: 84px;
            margin: 0 auto 1rem;
            border-radius: 24px;
            background: linear-gradient(135deg, rgba(123, 22, 244, 0.1), rgba(245, 138, 0, 0.1));
            border: 1px solid rgba(123, 22, 244, 0.12);
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.05);
          }

          body.sharkpay-panel .empty-state-illustration svg,
          body.sharkpay-panel .empty-state-illustration i {
            width: 34px;
            height: 34px;
            color: var(--sharkpay-purple-dark);
            stroke: var(--sharkpay-purple-dark);
          }

          body.sharkpay-panel .empty-state-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 84px;
            height: 84px;
            margin: 0 auto 1rem;
            border-radius: 24px;
            background: linear-gradient(135deg, rgba(123, 22, 244, 0.1), rgba(245, 138, 0, 0.1));
            border: 1px solid rgba(123, 22, 244, 0.12);
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.05);
          }

          body.sharkpay-panel .empty-state-icon svg,
          body.sharkpay-panel .empty-state-icon i {
            width: 34px;
            height: 34px;
            color: var(--sharkpay-purple-dark);
            stroke: var(--sharkpay-purple-dark);
          }

          body.sharkpay-panel .empty-state-title,
          body.sharkpay-panel .text-center.mt-8 h3,
          body.sharkpay-panel .text-center.mt-8 h4 {
            margin: 0 0 0.55rem;
            color: #111827 !important;
            font-size: clamp(1.8rem, 2.4vw, 2.15rem);
            font-weight: 700;
            line-height: 1.15;
            letter-spacing: -0.03em;
          }

          body.sharkpay-panel .empty-state-text,
          body.sharkpay-panel .text-center.mt-8 p,
          body.sharkpay-panel .text-center.mt-8 .card-text {
            max-width: 38rem;
            margin: 0 auto;
            color: #667085 !important;
            font-size: 1.1rem;
            line-height: 1.65;
            font-weight: 500;
          }

          body.sharkpay-panel .text-center.mt-8 .mb-3,
          body.sharkpay-panel .empty-state-icon,
          body.sharkpay-panel .empty-state-illustration {
            margin-bottom: 1.25rem;
          }

          body.sharkpay-panel .modal-body,
          body.sharkpay-panel .modal-header,
          body.sharkpay-panel .modal-footer {
            padding: 1.1rem 1.2rem;
          }

          body.sharkpay-panel .page-link {
            min-width: 38px;
            min-height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px !important;
            margin-right: .35rem;
            border-color: rgba(17, 24, 39, 0.08);
            color: var(--sharkpay-purple-dark);
            background: #fff;
          }

          body.sharkpay-panel .page-item.active .page-link {
            background: linear-gradient(135deg, var(--sharkpay-purple-dark), var(--sharkpay-purple));
            border-color: transparent;
            color: #fff;
          }

          body.sharkpay-panel .page-link:hover {
            background: #f7f4ff;
            color: var(--sharkpay-purple-dark);
          }

          body.sharkpay-panel .text-right .btn + .btn,
          body.sharkpay-panel .col-5.text-right .btn + .btn {
            margin-left: .45rem;
          }

          body.sharkpay-panel .empty-state,
          body.sharkpay-panel .text-center.mt-8 {
            padding: 2.2rem 1rem;
            border: 1px dashed rgba(123, 22, 244, 0.14);
            border-radius: 20px;
            background: rgba(255,255,255,0.72);
          }

          body.sharkpay-panel .main-content {
            background: transparent;
          }

          body.sharkpay-panel .header {
            margin: 0 1rem;
            padding-top: 1rem;
          }

          body.sharkpay-panel .header-body {
            min-height: 1rem;
          }

          body.sharkpay-panel .card,
          body.sharkpay-panel .table,
          body.sharkpay-panel .list-group-item,
          body.sharkpay-panel .modal-content {
            border: 1px solid rgba(17, 24, 39, 0.06);
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
          }

          @media (max-width: 991.98px) {
            body.sharkpay-panel .navbar-top,
            body.sharkpay-panel .header {
              margin-left: .85rem;
              margin-right: .85rem;
            }

            body.sharkpay-panel .dashboard-search {
              max-width: none;
            }

            body.sharkpay-panel .content-wrapper {
              padding-left: .85rem;
              padding-right: .85rem;
            }

            body.sharkpay-panel .panel-page-hero {
              padding: 1.2rem 1.15rem;
            }

            body.sharkpay-panel .panel-page-hero__title {
              font-size: 1.55rem;
            }
          }

          @media (max-width: 767.98px) {
            body.sharkpay-panel .nav-pills .nav-link {
              justify-content: flex-start;
              width: 100%;
            }

            body.sharkpay-panel .table-responsive {
              padding-left: .85rem !important;
              padding-right: .85rem !important;
            }
          }
         </style>
    </head>
<!-- header begin-->
<body class="sharkpay-panel">
  <!-- Mobile menu button (only visible on mobile) -->
  <button class="mobile-menu-toggle d-md-none" onclick="toggleMobileSidebar()">
    <i data-lucide="menu" style="width: 24px; height: 24px;"></i>
  </button>
  <div class="mobile-overlay" onclick="toggleMobileSidebar()"></div>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light" id="sidenav-main" style="max-width: 250px !important; min-width: 250px !important;">
    <div class="sidebar-scroll-area">
      <!-- Brand -->
      <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand" href="{{url('/')}}">
          <img src="{{url('/')}}/asset/images/logo_1735389067.png" class="navbar-brand-img" alt="SharkPay">
        </a>
        <div class="sidebar-account-card">
          <img src="{{url('/')}}/asset/profile/{{$cast}}" alt="{{$user->first_name}}" class="sidebar-account-card__avatar">
          <div class="sidebar-account-card__meta">
            <span class="sidebar-account-card__eyebrow">Workspace</span>
            <span class="sidebar-account-card__name">{{ $user->business_name ?: trim($user->first_name.' '.$user->last_name) }}</span>
            <span class="sidebar-account-card__subtext">{{$user->first_name}} {{$user->last_name}}</span>
            <div class="sidebar-account-card__chips">
              <span class="sidebar-account-chip">
                @if($user->business_level==1)
                  Starter
                @elseif($user->business_level==2)
                  Business
                @elseif($user->business_level==3)
                  Enterprise
                @else
                  Conta Ativa
                @endif
              </span>
              <span class="sidebar-account-chip {{ $user->kyc_status == 0 ? 'sidebar-account-chip--warning' : 'sidebar-account-chip--success' }}">
                {{ $user->kyc_status == 0 ? 'Verificacao pendente' : 'Verificado' }}
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav mb-3">
            <li class="nav-item">
              <a class="nav-link @if(route('user.dashboard')==url()->current()) active @endif" href="{{route('user.dashboard')}}">
                <i data-lucide="home" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">{{--$lang["user_layout_home"]--}}Dashboard</span>
              </a>
            </li>  
          </ul>
          <h6 class="navbar-heading p-0 text-muted">{{$lang["user_layout_your_business"]}}</h6>
          <ul class="navbar-nav mb-3">   
            @if($set->transfer==1)                                          
              <li class="nav-item">
                <a class="nav-link @if(route('user.transfer')==url()->current()) active @endif" href="{{route('user.transfer')}}">
                  <i data-lucide="shuffle" style="width: 20px; height: 20px;"></i>
                  <span class="nav-link-text">{{$lang["user_layout_transfer_money"]}}</span>
                  @if(count($p_transfer)>0)
                    <span class="badge badge-sm badge-circle badge-floating badge-danger border-white">{{count($p_transfer)}}</span>
                  @endif
                </a>
              </li>
            @endif
            <li class="nav-item">
              <a class="nav-link @if(route('user.fund')==url()->current()) active @endif" href="{{route('user.fund')}}">
                <i data-lucide="trending-up" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">{{$lang["user_layout_top_up_balance"]}}</span>
              </a>
            </li> 
            @if($set->vcard==1)
              @if($currency->name=='NGN' || $currency->name=='USD'  || $currency->name=='GNF' || $currency->name=='KES' || $currency->name=='LRD' || $currency->name=='MWK' || $currency->name=='MZN' || $currency->name=='RWF' || $currency->name=='SLL' || $currency->name=='BIF' || $currency->name=='CAD' || $currency->name=='CDF' || $currency->name=='CVE' || $currency->name=='EUR' || $currency->name=='GBP' || $currency->name=='GHS' || $currency->name=='GMD' || $currency->name=='STD' || $currency->name=='TZS' || $currency->name=='TZS' || $currency->name=='UGX' || $currency->name=='XAF' || $currency->name=='XOF' || $currency->name=='ZMK' || $currency->name=='ZMW' || $currency->name=='ZWD')   
                <li class="nav-item">
                  <a class="nav-link @if(route('user.virtualcard')==url()->current()) active @endif" href="{{route('user.virtualcard')}}">
                    <i data-lucide="credit-card" style="width: 20px; height: 20px;"></i>
                    <span class="nav-link-text">{{$lang["user_layout_virtual_cards"]}}</span>
                  </a>
                </li>
              @endif 
            @endif 
            @if($set->bill==1)            
              @if($currency->name=='NGN')            
              <li class="nav-item">
                <a class="nav-link @if(route('user.airtime')==url()->current() || route('user.data.bundle')==url()->current() || route('user.tv.cable')==url()->current() || route('user.electricity')==url()->current()) active @endif" href="#bill" data-toggle="collapse" role="button" aria-expanded="fasse" aria-controls="bill">
                  <!--For modern browsers-->
                  <i data-lucide="banknote" style="width: 20px; height: 20px;"></i>
                  <span class="nav-link-text">{{$lang["user_layout_bill_payment"]}}</span>
                </a>
                <div class="collapse @if(route('user.airtime')==url()->current() || route('user.data.bundle')==url()->current() || route('user.tv.cable')==url()->current() || route('user.electricity')==url()->current()) show @endif" id="bill">
                  <ul class="nav nav-sm flex-column">
                    <li class="nav-item @if(route('user.airtime')==url()->current()) active @endif text-default">
                      <a href="{{route('user.airtime')}}" class="nav-link">{{$lang["user_layout_airtime"]}}</a>
                    </li>                                 
                    <li class="nav-item @if(route('user.data.bundle')==url()->current()) active @endif text-default">
                      <a href="{{route('user.data.bundle')}}" class="nav-link">{{$lang["user_layout_data_bundle"]}}</a>
                    </li>                          
                    <li class="nav-item @if(route('user.tv.cable')==url()->current()) active @endif text-default">
                      <a href="{{route('user.tv.cable')}}" class="nav-link">{{$lang["user_layout_tvcable"]}}</a>
                    </li>                   
                    <li class="nav-item @if(route('user.electricity')==url()->current()) active @endif text-default">
                      <a href="{{route('user.electricity')}}" class="nav-link">{{$lang["user_layout_eletricity"]}}</a>
                    </li>                               
                  </ul>
                </div>
              </li> 
              @endif  
            @endif  
            <!--
            <li class="nav-item">
              <a class="nav-link @if(route('user.btc')==url()->current() || route('user.eth')==url()->current()) active @endif" href="#crypto" data-toggle="collapse" role="button" aria-expanded="fasse" aria-controls="crypto">
                <i class="fas fa-sync"></i>
                <span class="nav-link-text">{{__('Buy & Sell Crypto')}}</span>
              </a>
              <div class="collapse @if(route('user.btc')==url()->current() || route('user.eth')==url()->current()) show @endif" id="crypto">
                <ul class="nav nav-sm flex-column">
                  @if($set->bitcoin==1)
                  <li class="nav-item @if(route('user.btc')==url()->current()) active @endif text-default">
                    <a href="{{route('user.btc')}}" class="nav-link">{{__('Bitcoin')}}</a>
                  </li> 
                  @endif 
                  @if($set->ethereum==1)                               
                  <li class="nav-item @if(route('user.eth')==url()->current()) active @endif text-default">
                    <a href="{{route('user.eth')}}" class="nav-link">{{__('Ethereum')}}</a>
                  </li>
                  @endif                               
                </ul>
              </div>
            </li>  
            -->  
            <li class="nav-item">
              <a class="nav-link @if(route('user.ticket')==url()->current() || route('open.ticket')==url()->current()) active @endif" href="{{route('user.ticket')}}">
                <i data-lucide="flag" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">{{$lang["user_layout_disputes"]}}</span>
              </a>
            </li>         
            
            <?php  /*
            <li class="nav-item">
              <a class="nav-link @if(route('user.sub')==url()->current() || route('user.sub')==url()->current()) active @endif" href="{{route('user.sub')}}">
                <i class="fas fa-user"></i>
                <span class="nav-link-text">{{$lang["user_layout_subscribers"]}}</span>
              </a>
            </li>  
            */ ?>          
            <li class="nav-item">
              <a class="nav-link @if(route('user.transactions')==url()->current()) active @endif" href="{{route('user.transactions')}}">
                <i data-lucide="receipt" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">{{$lang["user_layout_transactions"]}}</span>
              </a>
            </li>        
            <li class="nav-item">
              <a class="nav-link @if(route('user.withdraw')==url()->current()) active @endif" href="{{route('user.withdraw')}}">
                <i data-lucide="arrow-down-circle" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">{{$lang["user_layout_payout"]}}</span>
              </a>
            </li>   
            <li class="nav-item">
              <a class="nav-link @if(route('user.charges')==url()->current()) active @endif" href="{{route('user.charges')}}">
                <i data-lucide="percent" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">{{$lang["user_layout_charges"]}}</span>
              </a>
            </li>             
            <li class="nav-item">
              <a class="nav-link @if(route('user.subaccounts')==url()->current()) active @endif" href="{{route('user.subaccounts')}}">
                <i data-lucide="users" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">{{$lang["user_layout_sub_accounts"]}}</span>
              </a>
            </li>
            @if($stripe->status==1)        
            <li class="nav-item">
              <a class="nav-link @if(route('user.chargeback')==url()->current()) active @endif" href="{{route('user.chargeback')}}">
                <i data-lucide="rotate-ccw" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">{{$lang["user_layout_charge_backs"]}}</span>
              </a>
            </li> 
            @endif                                             
          </ul>
          <h6 class="navbar-heading p-0 text-muted">{{$lang["user_layout_collect_payments"]}}</h6>
          <ul class="navbar-nav mb-3"> 
            @if($set->store==1) 
            <li class="nav-item">
              <a class="nav-link @if(route('user.product')==url()->current()) active @endif" href="{{route('user.product')}}">
                <i data-lucide="shopping-bag" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">{{$lang["user_layout_products"]}}</span>
              </a>
            </li> 
            <li class="nav-item">
              <a class="nav-link @if(route('user.storefront')==url()->current()) active @endif" href="{{route('user.storefront')}}">
                <i data-lucide="store" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">{{$lang["user_layout_store_front"]}}</span>
              </a>
            </li>           
            <li class="nav-item">
              <a class="nav-link @if(route('user.list')==url()->current()) active @endif" href="{{route('user.list')}}">
                <i data-lucide="shopping-cart" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">{{$lang["user_layout_orders"]}}</span>
              </a>
            </li> 
            @endif
            @if($set->request_money==1)
            <li class="nav-item">
              <a class="nav-link @if(route('user.request')==url()->current()) active @endif" href="{{route('user.request')}}">
                <i data-lucide="wallet" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">{{$lang["user_layout_request_money"]}}</span>
                @if(count($p_request)>0)
                  <span class="badge badge-sm badge-circle badge-floating badge-danger border-white">{{count($p_request)}}</span>
                @endif
              </a>
            </li>   
            @endif         
            @if($set->single==1)
              <li class="nav-item">
                <a class="nav-link @if(route('user.sclinks')==url()->current()) active @endif" href="{{route('user.sclinks')}}">
                  <i data-lucide="link" style="width: 20px; height: 20px;"></i>
                  <span class="nav-link-text">{{$lang["user_layout_single_charge"]}}</span>
                </a>
              </li>
            @endif
            @if($set->donation==1)                            
              <li class="nav-item">
                <a class="nav-link @if(route('user.dplinks')==url()->current()) active @endif" href="{{route('user.dplinks')}}">
                  <i data-lucide="gift" style="width: 20px; height: 20px;"></i>
                  <span class="nav-link-text">{{$lang["user_layout_donation"]}}</span>
                </a>
              </li> 
            @endif  
            @if($set->invoice==1)  
            <li class="nav-item">
              <a class="nav-link @if(route('user.invoice')==url()->current()) active @endif" href="{{route('user.invoice')}}">
                <i data-lucide="mail" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">{{$lang["user_layout_invoice"]}}</span>
              </a>
            </li>
            @endif      
            
            <?php /*
            @if($set->subscription==1)  
            <li class="nav-item">
              <a class="nav-link @if(route('user.plan')==url()->current()) active @endif" href="{{route('user.plan')}}">
                <i class="fas fa-layer-group"></i>
                <span class="nav-link-text">{{$lang["user_layout_plan"]}}</span>
              </a>
            </li>
            @endif  
            */ ?>

            @if($set->merchant==1)
            <!--
              <li class="nav-item">
                <a class="nav-link @if(route('user.merchant')==url()->current()) active @endif" href="{{route('user.merchant')}}">
                  <i class="fas fa-laptop"></i>
                  <span class="nav-link-text">{{$lang["user_layout_website_integration"]}}</span>
                </a>
              </li>  
            -->
                <li class="nav-item">
                    <a class="nav-link @if(route('user.merchant')==url()->current()) active @endif" target="DOCS" href="https://documenter.getpostman.com/view/2065421/UzXLyHss">
                  <i data-lucide="code-2" style="width: 20px; height: 20px;"></i>
                  <span class="nav-link-text">{{$lang["user_layout_website_integration"]}}</span>
                </a>
              </li>  
            @endif
          </ul>

          <!-- Enhanced Features Section -->
          <h6 class="navbar-heading p-0 text-muted">Recursos Avançados</h6>
          <ul class="navbar-nav mb-3">
            <li class="nav-item">
              <a class="nav-link @if(route('user.enhanced-dashboard')==url()->current()) active @endif" href="{{route('user.enhanced-dashboard')}}">
                <i data-lucide="layout-dashboard" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">Dashboard Avançado</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(route('user.checkout-builder.index')==url()->current()) active @endif" href="{{route('user.checkout-builder.index')}}">
                <i data-lucide="package-plus" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">Checkout Builder</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(route('user.payment-config.index')==url()->current()) active @endif" href="{{route('user.payment-config.index')}}">
                <i data-lucide="settings" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">Configurar Pagamentos</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(route('user.payouts.index')==url()->current()) active @endif" href="{{route('user.payouts.index')}}">
                <i data-lucide="banknote" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">Saques</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(route('user.refunds.index')==url()->current()) active @endif" href="{{route('user.refunds.index')}}">
                <i data-lucide="rotate-ccw" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">Reembolsos</span>
              </a>
            </li>
          </ul>

          <!-- Seller Section (Infoprodutos) -->
          <h6 class="navbar-heading p-0 text-muted">Vendas de Infoprodutos</h6>
          <ul class="navbar-nav mb-3">
            <li class="nav-item">
              <a class="nav-link @if(request()->is('seller/dashboard')) active @endif" href="{{route('seller.dashboard')}}">
                <i data-lucide="trending-up" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">Dashboard de Vendas</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->is('seller/products*')) active @endif" href="#seller-products" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="seller-products">
                <i data-lucide="package" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">Produtos Digitais</span>
              </a>
              <div class="collapse @if(request()->is('seller/products*')) show @endif" id="seller-products">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{route('seller.products')}}" class="nav-link">Listar Produtos</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('seller.products.create')}}" class="nav-link">Criar Produto</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->is('seller/reports*') || request()->is('seller/analytics')) active @endif" href="#seller-reports" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="seller-reports">
                <i data-lucide="bar-chart-2" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">Relatórios & Analytics</span>
              </a>
              <div class="collapse @if(request()->is('seller/reports*') || request()->is('seller/analytics')) show @endif" id="seller-reports">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{route('seller.reports.sales')}}" class="nav-link">Vendas</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('seller.reports.customers')}}" class="nav-link">Clientes</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('seller.reports.products')}}" class="nav-link">Produtos</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('seller.analytics')}}" class="nav-link">Analytics</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->is('seller/balance') || request()->is('seller/withdrawals') || request()->is('seller/commissions')) active @endif" href="#seller-financial" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="seller-financial">
                <i data-lucide="dollar-sign" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">Financeiro</span>
              </a>
              <div class="collapse @if(request()->is('seller/balance') || request()->is('seller/withdrawals') || request()->is('seller/commissions')) show @endif" id="seller-financial">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{route('seller.balance')}}" class="nav-link">Saldo</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('seller.withdrawals')}}" class="nav-link">Saques</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('seller.commissions')}}" class="nav-link">Comissões</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->is('seller/settings*')) active @endif" href="#seller-settings" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="seller-settings">
                <i data-lucide="settings" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">Configurações</span>
              </a>
              <div class="collapse @if(request()->is('seller/settings*')) show @endif" id="seller-settings">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{route('seller.settings.payment-methods')}}" class="nav-link">Métodos de Pagamento</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('seller.settings.notifications')}}" class="nav-link">Notificações</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('seller.settings.tax')}}" class="nav-link">Fiscal</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('seller.settings.api')}}" class="nav-link">API Keys</a>
                  </li>
                </ul>
              </div>
            </li>
          </ul>

          <!-- Affiliate Section -->
          <h6 class="navbar-heading p-0 text-muted">Sistema de Afiliados</h6>
          <ul class="navbar-nav mb-3">
            <li class="nav-item">
              <a class="nav-link @if(request()->is('affiliate/dashboard')) active @endif" href="{{route('affiliate.dashboard')}}">
                <i data-lucide="users" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">Dashboard Afiliado</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->is('affiliate/marketplace') || request()->is('affiliate/my-products')) active @endif" href="#affiliate-marketplace" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="affiliate-marketplace">
                <i data-lucide="shopping-bag" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">Marketplace</span>
              </a>
              <div class="collapse @if(request()->is('affiliate/marketplace') || request()->is('affiliate/my-products')) show @endif" id="affiliate-marketplace">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{route('affiliate.marketplace')}}" class="nav-link">Produtos Disponíveis</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('affiliate.my-products')}}" class="nav-link">Meus Produtos</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->is('affiliate/links') || request()->is('affiliate/campaigns') || request()->is('affiliate/tracking')) active @endif" href="#affiliate-promotion" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="affiliate-promotion">
                <i data-lucide="megaphone" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">Promoção</span>
              </a>
              <div class="collapse @if(request()->is('affiliate/links') || request()->is('affiliate/campaigns') || request()->is('affiliate/tracking')) show @endif" id="affiliate-promotion">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{route('affiliate.links')}}" class="nav-link">Links</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('affiliate.campaigns')}}" class="nav-link">Campanhas</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('affiliate.tracking')}}" class="nav-link">Rastreamento</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->is('affiliate/reports*')) active @endif" href="#affiliate-reports" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="affiliate-reports">
                <i data-lucide="pie-chart" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">Relatórios</span>
              </a>
              <div class="collapse @if(request()->is('affiliate/reports*')) show @endif" id="affiliate-reports">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{route('affiliate.reports.conversions')}}" class="nav-link">Conversões</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('affiliate.reports.earnings')}}" class="nav-link">Ganhos</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('affiliate.reports.performance')}}" class="nav-link">Performance</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->is('affiliate/payments') || request()->is('affiliate/payment-settings')) active @endif" href="{{route('affiliate.payments')}}">
                <i data-lucide="wallet" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">Pagamentos</span>
              </a>
            </li>
          </ul>

          <!-- Customer Section -->
          <h6 class="navbar-heading p-0 text-muted">Área do Cliente</h6>
          <ul class="navbar-nav mb-3">
            <li class="nav-item">
              <a class="nav-link @if(request()->is('customer/purchases')) active @endif" href="{{route('customer.purchases')}}">
                <i data-lucide="shopping-cart" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">Minhas Compras</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->is('customer/downloads')) active @endif" href="{{route('customer.downloads')}}">
                <i data-lucide="download" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">Downloads</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->is('customer/courses')) active @endif" href="{{route('customer.courses')}}">
                <i data-lucide="book-open" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">Cursos</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->is('customer/subscriptions')) active @endif" href="{{route('customer.subscriptions')}}">
                <i data-lucide="credit-card" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">Assinaturas</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->is('customer/support*')) active @endif" href="{{route('customer.support.tickets')}}">
                <i data-lucide="headphones" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">Suporte</span>
              </a>
            </li>
          </ul>

          <h6 class="navbar-heading p-0 text-muted">{{$lang["user_layout_menu_reports"]}}</h6>
          <ul class="navbar-nav mb-3">   
            <li class="nav-item">
              <a class="nav-link @if(route('user.reports.invoices')==url()->current()) active @endif" href="{{route('user.reports.invoices')}}">
                <i data-lucide="scan" style="width: 20px; height: 20px;"></i>
                <span class="nav-link-text">{{$lang["user_layout_menu_reports_invoices"]}}</span>
              </a>
              </li> <li class="nav-item">
                <a class="nav-link @if(route('user.reports.funds')==url()->current()) active @endif" href="{{route('user.reports.funds')}}">
                  <i data-lucide="trending-up" style="width: 20px; height: 20px;"></i>
                  <span class="nav-link-text">{{$lang["user_layout_menu_reports_funds"]}}</span>
                </a>
              </li> <li class="nav-item">
                <a class="nav-link @if(route('user.reports.links')==url()->current()) active @endif" href="{{route('user.reports.links')}}">
                  <i data-lucide="link" style="width: 20px; height: 20px;"></i>
                  <span class="nav-link-text">{{$lang["user_layout_menu_reports_links"]}}</span>
                </a>
              </li> <li class="nav-item">
                <a class="nav-link @if(route('user.reports.donations')==url()->current()) active @endif" href="{{route('user.reports.donations')}}">
                  <i data-lucide="gift" style="width: 20px; height: 20px;"></i>
                  <span class="nav-link-text">{{$lang["user_layout_menu_reports_donations"]}}</span>
                </a>
              </li> <li class="nav-item">
                <a class="nav-link @if(route('user.reports.orders')==url()->current()) active @endif" href="{{route('user.reports.orders')}}">
                  <i data-lucide="shopping-cart" style="width: 20px; height: 20px;"></i>
                  <span class="nav-link-text">{{$lang["user_layout_menu_reports_orders"]}}</span>
                </a>
              </li> <li class="nav-item">
                <a class="nav-link @if(route('user.reports.products')==url()->current()) active @endif" href="{{route('user.reports.products')}}">
                <i data-lucide="shopping-bag" style="width: 20px; height: 20px;"></i>
                  <span class="nav-link-text">{{$lang["user_layout_menu_reports_products"]}}</span>
                </a>
              </li> 

          </ul>


        </div>
      </div>
    </div>
  </nav>
   <div class="main-content" id="panel" style="margin-left: 250px !important;">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand border-bottom-0">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Search form -->
            
          <!-- Navbar links -->
          
          <form class="navbar-search navbar-search-light form-inline mr-sm-3 dashboard-search" action="{{route('search')}}" method="post" id="navbar-search-main">
            @csrf
            <div class="form-group mb-0">
              <div class="input-group input-group-alternative input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i data-lucide="search" style="width: 16px; height: 16px;"></i></span>
                </div>
                <input class="form-control" placeholder="{{$lang["user_layout_transactions_payment_reference"]}}" name="search" type="text">
              </div>
            </div>
            <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
              <span aria-hidden="true" class="text-dark">×</span>
            </button>
          </form>
          
          <ul class="navbar-nav align-items-center ml-md-auto">
            
            <li class="nav-item d-sm-none">
                <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                  <i data-lucide="search" style="width: 20px; height: 20px;" class="text-dark"></i>
                </a>
              </li>
            
          </ul>
            <ul class="navbar-nav align-items-center ml-auto ml-md-0">    
              <li class="nav-item mr-2">
                <h6 class="h4 mb-0 text-gray font-weight-bolder dashboard-balance-chip"><i data-lucide="wallet" style="width: 20px; height: 20px; display: inline-block; vertical-align: middle;"></i><span>{{number_format($user->balance, 2, '.', '').$currency->name}}</span></h6>
              </li>              
              <li class="nav-item dropdown">
                <a class="nav-link pr-0 dashboard-profile-link" aria-haspopup="true" aria-expanded="fasse">
                  <div class="media align-items-center">
                    <span class="avatar avatar-md rounded-circle">
                      <img alt="Image placeholder" src="{{url('/')}}/asset/profile/{{$cast}}">
                    </span>
                  </div>
                </a>
              </li>
            </ul>
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link pr-0 dashboard-profile-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="fasse">
                  <i data-lucide="chevron-down-circle" style="width: 24px; height: 24px;" class="text-dark"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                  <a href="{{route('user.profile')}}" class="dropdown-item">
                    <i data-lucide="user" style="width: 16px; height: 16px;"></i>
                    <span>{{$lang["user_layout_profile"]}}</span>
                  </a>                  
                  <a href="{{route('user.api')}}" class="dropdown-item">
                    <i data-lucide="key" style="width: 16px; height: 16px;"></i>
                    <span>{{$lang["user_layout_api_keys"]}}</span>
                  </a>                  
                  <a href="{{route('user.security')}}" class="dropdown-item">
                    <i data-lucide="lock" style="width: 16px; height: 16px;"></i>
                    <span>{{$lang["user_layout_security"]}}</span>
                  </a>                 
                  <a href="{{route('user.bank')}}" class="dropdown-item">
                    <i data-lucide="building" style="width: 16px; height: 16px;"></i>
                    <span>{{$lang["user_layout_bank_accounts"]}}</span>
                  </a>                  
                  <a href="{{route('user.social')}}" class="dropdown-item">
                    <i data-lucide="share-2" style="width: 16px; height: 16px;"></i>
                    <span>{{$lang["user_layout_social_accounts"]}}</span>
                  </a>     
                    
                    @if ($user->compliance_gateway == "BANCO_ORIGINAL") 
                    <a href="{{route('user.account-compliance')}}" class="dropdown-item">
                      <i data-lucide="globe" style="width: 16px; height: 16px;"></i>
                      <span>{{$lang["user_layout_account_compliance"]}}</span>
                    </a>
                    @endif
                    
                  <a href="{{route('user.ticket')}}" class="dropdown-item">
                    <i data-lucide="message-circle" style="width: 16px; height: 16px;"></i>
                    <span>{{$lang["user_layout_support"]}}</span>
                  </a>      
                    
                  <a href="{{route('user.audit')}}" class="dropdown-item">
                    <i data-lucide="clock" style="width: 16px; height: 16px;"></i>
                    <span>{{$lang["user_layout_audit_logs"]}}</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="{{route('user.logout')}}" class="dropdown-item">
                    <i data-lucide="log-out" style="width: 16px; height: 16px;"></i>
                    <span>{{$lang["user_layout_logout"]}}</span>
                  </a>
                </div>
              </li>
            </ul>
        </div>
      </div>
    </nav>
<!-- header end -->
@yield('content')


<!-- footer begin -->
      <footer class="footer pt-0">

      </footer>
    </div>
  </div>
  {!!$livechatCode!!}
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{url('/')}}/asset/dashboard/vendor/jquery/dist/jquery.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/js-cookie/js.cookie.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
  <!-- Optional JS -->
  <script src="{{url('/')}}/asset/dashboard/vendor/chart.js/dist/Chart.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/chart.js/dist/Chart.extension.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/jvectormap-next/jquery-jvectormap.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/js/vendor/jvectormap/jquery-jvectormap-world-mill.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/datatables.net-select/js/dataTables.select.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/datatables.net-buttons/js/jszip.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/datatables.net-buttons/js/pdfmake.min..js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/datatables.net-buttons/js/vfs_fonts.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/clipboard/dist/clipboard.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/select2/dist/js/select2.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/nouislider/distribute/nouislider.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/quill/dist/quill.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/dropzone/dist/min/dropzone.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
  <!-- Argon JS -->
  <script src="{{url('/')}}/asset/dashboard/js/argon.js?v=1.1.0"></script>
  <!-- Demo JS - remove this in your project -->
  <script src="{{url('/')}}/asset/dashboard/js/demo.min.js"></script>
  <!--<script src="{{url('/')}}/asset/js/sweetalert.js"></script>-->
  <script src="{{url('/')}}/asset/js/toast.js"></script>
  <script src="{{url('/')}}/asset/js/countries.js"></script>
  <script src="{{url('/')}}/asset/tinymce/tinymce.min.js"></script>
  <script src="{{url('/')}}/asset/tinymce/init-tinymce.js"></script>


  <script src="{{url('/')}}/asset/js/jquery.maskedinput.min.js"></script>
  <script src="{{url('/')}}/asset/js/jquery.alphanumeric.js"></script>
  <script src="{{url('/')}}/asset/js/ajaxform.js"></script>
  <script src="{{url('/')}}/asset/js/priceformat/jquery.price_format.js"></script>
  <script src="{{url('/')}}/asset/js/jquery.inputmask.js"></script>
  

  
  @stack('scripts')
  
</body>

</html>
<script>
  // Initialize Lucide icons
  lucide.createIcons();

  function replaceLegacyEmptyStateImages() {
    const legacyEmptyImages = document.querySelectorAll('img[src*="/asset/images/empty.svg"], img[src$="asset/images/empty.svg"]');

    legacyEmptyImages.forEach((image) => {
      const replacement = document.createElement('div');
      replacement.className = 'empty-state-illustration';
      replacement.setAttribute('aria-hidden', 'true');
      replacement.innerHTML = '<i data-lucide="inbox"></i>';

      image.parentNode.replaceChild(replacement, image);
    });
  }

  function replaceLegacyEmptyStateIcons() {
    const legacyEmptyIcons = document.querySelectorAll([
      '.text-center.mt-8 > i.bi.bi-archive',
      '.text-center.mt-8 > i.fa.fa-archive',
      '.text-center.mt-8 > i.fas.fa-archive',
      '.text-center.mt-8 > i.fa.fa-folder',
      '.text-center.mt-8 > i.fas.fa-folder',
      '.text-center.mt-8 > i.fa.fa-folder-open',
      '.text-center.mt-8 > i.fas.fa-folder-open',
      '.empty-state-icon > i.bi.bi-archive',
      '.empty-state-icon > i.fa.fa-archive',
      '.empty-state-icon > i.fas.fa-archive',
      '.empty-state-icon > i.fa.fa-folder',
      '.empty-state-icon > i.fas.fa-folder',
      '.empty-state-icon > i.fa.fa-folder-open',
      '.empty-state-icon > i.fas.fa-folder-open'
    ].join(', '));

    legacyEmptyIcons.forEach((icon) => {
      const replacement = document.createElement('div');
      replacement.className = icon.parentElement.classList.contains('empty-state-icon') ? 'empty-state-icon' : 'empty-state-illustration';
      replacement.setAttribute('aria-hidden', 'true');
      replacement.innerHTML = '<i data-lucide="inbox"></i>';

      icon.parentNode.replaceChild(replacement, icon);
    });
  }

  // Re-initialize after any dynamic content loads
  document.addEventListener('DOMContentLoaded', function() {
    replaceLegacyEmptyStateImages();
    replaceLegacyEmptyStateIcons();
    lucide.createIcons();
    
    // Remove Argon sidebar classes to prevent hover effects
    document.body.classList.remove('g-sidenav-show');
    document.body.classList.remove('g-sidenav-hidden');
    document.body.classList.remove('g-sidenav-pinned');
    document.body.classList.add('g-sidenav-pinned'); // Force pinned state
    
    // Disable Argon sidebar functionality
    if (window.Sidenav) {
      window.Sidenav = null;
    }
    
    // Remove any event listeners on sidebar
    const sidebar = document.getElementById('sidenav-main');
    if (sidebar) {
      const newSidebar = sidebar.cloneNode(true);
      sidebar.parentNode.replaceChild(newSidebar, sidebar);
      
      // Remove hover handlers
      sidebar.onmouseenter = null;
      sidebar.onmouseleave = null;
      sidebar.onmouseover = null;
      sidebar.onmouseout = null;
      
      // Remove all event listeners from sidebar elements
      const sidebarElements = sidebar.querySelectorAll('*');
      sidebarElements.forEach(el => {
        el.onmouseenter = null;
        el.onmouseleave = null;
        el.onmouseover = null;
        el.onmouseout = null;
      });
    }
    
    // Override Argon's sidenav script
    if (window.$) {
      $('[data-action="sidenav-pin"]').off();
      $('[data-action="sidenav-unpin"]').off();
      $('.sidenav').off('mouseenter mouseleave');
    }
  });
  
  // Mobile sidebar toggle
  function toggleMobileSidebar() {
    const sidebar = document.getElementById('sidenav-main');
    const overlay = document.querySelector('.mobile-overlay');
    
    sidebar.classList.toggle('mobile-show');
    overlay.classList.toggle('show');
    
    // Re-initialize Lucide icons after toggle
    setTimeout(() => {
      lucide.createIcons();
    }, 100);
  }
</script>
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

<script>

      $(document).ready(function () {
          $(".date-mask").mask("99/99/9999");
      });
      

</script>

<script>
    try {
        populateCountries("country", "state");
    } catch(e) {
        console.log(e);
    }
    try {
        populateIndustry("industry", "category");
    } catch(e) {
        console.log(e);
    }
</script>
<script>
"use strict"



function get_form_csrf_data(formid) {

    let ajaxcointableform = JSON.stringify($('#'+formid).serializeArray());
    let formdata          = $.parseJSON(ajaxcointableform);
    for (let i = 0; i < formdata.length; i++) {
        let inputname         = formdata[i]['name'];
        let inputval          = formdata[i]['value'];

        if (inputname === '_token') {
            return inputval;
        }
    }
}



function check(){
    if ($("#seeAnotherField").val() == "{{$lang['user_layout_registered_business']}}") {
      $('#otherFieldDiv').show();
      $('#otherField').attr('required', '');
      $('#otherField').attr('data-error', '{{$lang["user_layout_this_field_is_required"]}}');  
      $('#6xxotherFieldDiv').show(); 
      $('#6xxotherField').attr('required', '');
      $('#6xxotherField').attr('data-error', '{{$lang["user_layout_this_field_is_required"]}}'); 
      $('#fFieldDiv').show();
      $('#fField').attr('required', '');
      $('#fField').attr('data-error', '{{$lang["user_layout_this_field_is_required"]}}');         
      $('#ffFieldDiv').show();
      $('#ffField').attr('required', '');
      $('#ffField').attr('data-error', '{{$lang["user_layout_this_field_is_required"]}}');    
      $('#otherFieldDiv1').show();
      $('#otherField1').attr('required', '');
      $('#otherField1').attr('data-error', '{{$lang["user_layout_this_field_is_required"]}}');      
      $('#otherFieldDiv2').show();
      $('#customFileLang').attr('required', '');
      $('#customFileLang').attr('data-error', '{{$lang["user_layout_this_field_is_required"]}}');  
      $('#otherFieldDiv3').hide();
      $('#customFileLang').removeAttr('required');
      $('#customFileLang').removeAttr('data-error');      
      $('#1otherField').removeAttr('required');
      $('#1otherField').removeAttr('data-error');      
      $('#2otherField').removeAttr('required');
      $('#2otherField').removeAttr('data-error');      
      $('#3otherField').removeAttr('required');
      $('#3otherField').removeAttr('data-error');      
      $('#4otherField').removeAttr('required');
      $('#4otherField').removeAttr('data-error');      
      $('#5otherField').removeAttr('required');
      $('#5otherField').removeAttr('data-error');      
      $('#6otherField').removeAttr('required');
      $('#6otherField').removeAttr('data-error');      
      $('#6xotherField').removeAttr('required');
      $('#6xotherField').removeAttr('data-error');       
      $('#60otherField').removeAttr('required');
      $('#60otherField').removeAttr('data-error');   
      $('#60xotherField').removeAttr('required');
      $('#60xotherField').removeAttr('data-error'); 
      $('#7otherField').removeAttr('required');
      $('#7otherField').removeAttr('data-error');       
      $('#70otherField').removeAttr('required');
      $('#70otherField').removeAttr('data-error');      
      $('#8otherField').removeAttr('required');
      $('#8otherField').removeAttr('data-error');      
    } else {
      $('#otherFieldDiv').hide();
      $('#otherField').removeAttr('required');
      $('#otherField').removeAttr('data-error');      
      $('#otherFieldDiv1').hide();
      $('#otherField1').removeAttr('required');
      $('#otherField1').removeAttr('data-error');      
      $('#otherFieldDiv2').hide();
      $('#otherFieldDiv3').show();
      $('#1otherField').attr('required', '');
      $('#1otherField').attr('data-error', '{{$lang["user_layout_this_field_is_required"]}}');      
      $('#2otherField').attr('required', '');
      $('#3otherField').attr('required', '');
      $('#3otherField').attr('data-error', '{{$lang["user_layout_this_field_is_required"]}}');      
      $('#4otherField').attr('required', '');
      $('#4otherField').attr('data-error', '{{$lang["user_layout_this_field_is_required"]}}');
      $('#5otherField').attr('required', '');
      $('#5otherField').attr('data-error', '{{$lang["user_layout_this_field_is_required"]}}');
      $('#6otherField').attr('required', '');
      $('#6otherField').attr('data-error', '{{$lang["user_layout_this_field_is_required"]}}');      
      $('#6xotherField').attr('required', '');
      $('#6xotherField').attr('data-error', '{{$lang["user_layout_this_field_is_required"]}}');      
      $('#60otherField').attr('required', '');
      $('#60otherField').attr('data-error', '{{$lang["user_layout_this_field_is_required"]}}');
      $('#60xotherField').attr('required', '');
      $('#60xotherField').attr('data-error', '{{$lang["user_layout_this_field_is_required"]}}');
      $('#6xxotherFieldDiv').hide();
      $('#6xxotherField').removeAttr('required');
      $('#6xxotherField').removeAttr('data-error');    
      $('#fFieldDiv').hide();
      $('#fField').removeAttr('required');
      $('#fField').removeAttr('data-error');    
      $('#ffFieldDiv').hide();
      $('#ffField').removeAttr('required');
      $('#ffField').removeAttr('data-error');    
      $('#7otherField').attr('required', '');
      $('#7otherField').attr('data-error', '{{$lang["user_layout_this_field_is_required"]}}');      
      $('#70otherField').attr('required', '');
      $('#70otherField').attr('data-error', '{{$lang["user_layout_this_field_is_required"]}}');
      $('#8otherField').attr('required', '');
      $('#8otherField').attr('data-error', '{{$lang["user_layout_this_field_is_required"]}}');
    
    }
}
$("#seeAnotherField").change(check);
  check();  
</script>
<script>
    
    try {
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [<?php foreach($history as $val){ echo "'".date("M j",strtotime($val->updated_at))."'".','; }?>],
                datasets: [{
                    label: 'Received',
                    data: [<?php foreach($history as $val){ echo $val->amount.','; }?>],
                    backgroundColor: [
                        'transparent'
                    ],
                    borderColor: [
                        '#058d27'
                    ],
                    borderWidth: 1,
                    pointBorderColor: 'rgba(0, 0, 0, 0.1)',
                    pointBorderWidth:1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontColor: '#32325d'
                        }
                    }],       
                    xAxes: [{
                        ticks: {
                            fontColor: '#32325d'
                        }
                    }]
                },
              tooltips: {
                enabled:true,
                backgroundColor:'rgba(0, 0, 0, 0.8)'
              }
            }
          });
    } catch (e) {
        console.log(e);
    }
</script>
@foreach($xvcard as $k=>$v)
  <script type="text/javascript">
  "use strict";
  function virtualcharge(){
    var amount@php echo $v->id; @endphp = $("#amounttransfer4{{$v->id}}").val();
    var charge@php echo $v->id; @endphp = $("#vtransfer3{{$v->id}}").val();
    var chargep@php echo $v->id; @endphp = $("#vtransferx{{$v->id}}").val();
    var survix@php echo $v->id; @endphp =  parseFloat(amount@php echo $v->id; @endphp)-parseFloat(chargep@php echo $v->id; @endphp)-(parseFloat(amount@php echo $v->id; @endphp)*parseFloat(charge@php echo $v->id; @endphp)/100);
    var cur = '{{$currency->name}}';
    if(isNaN(survix@php echo $v->id; @endphp) || survix@php echo $v->id; @endphp<0){
      survix@php echo $v->id; @endphp =0;           
    }
    var ddd@php echo $v->id; @endphp = survix@php echo $v->id; @endphp.toFixed(2)+' '+cur;
    $("#resulttransfer4{{$v->id}}").text(ddd@php echo $v->id; @endphp);
  }  
  $("#amounttransfer4{{$v->id}}").keyup(virtualcharge);
  virtualcharge();
  </script>
@endforeach
@foreach($xvcard as $k=>$v)
<script type="text/javascript">
  "use strict";
  function fundcharge(){
    var amount@php echo $v->id; @endphp = $("#amounttransfer5{{$v->id}}").val();
    var charge@php echo $v->id; @endphp = $("#vtransfer3{{$v->id}}").val();
    var chargep@php echo $v->id; @endphp = $("#vtransferx{{$v->id}}").val();
    var survix@php echo $v->id; @endphp =  parseFloat(amount@php echo $v->id; @endphp)+parseFloat(chargep@php echo $v->id; @endphp)+(parseFloat(amount@php echo $v->id; @endphp)*parseFloat(charge@php echo $v->id; @endphp)/100);
    var cur = '{{$currency->name}}';
    if(isNaN(survix@php echo $v->id; @endphp) || survix@php echo $v->id; @endphp<0){
      survix@php echo $v->id; @endphp =0;           
    }
    var ddd@php echo $v->id; @endphp = survix@php echo $v->id; @endphp.toFixed(2)+' '+cur;
    $("#resulttransfer5{{$v->id}}").text(ddd@php echo $v->id; @endphp);
  }
  $("#amounttransfer5{{$v->id}}").keyup(fundcharge);
  fundcharge();
</script>
@endforeach

<script type="text/javascript">
  "use strict";
  function withdrawcharge(){
    var amount = $("#amounttransfer3").val();
    var charge = $("#chargetransfer3").val();
    var charge1 = $("#chargetransferx").val();
    var survix =  parseFloat(amount)-parseFloat(charge1)-(parseFloat(amount)*parseFloat(charge)/100);
    var cur = '{{$currency->name}}';
    if(isNaN(survix) || survix<0){
      survix =0;           
    }
    var ddd = cur+' '+survix.toFixed(2);
    $("#resulttransfer3").text(ddd);
  }  
  </script>
  
  <script type="text/javascript">
  "use strict";
  function createcharge(){
    var amount = $("#createamount").val();
    var charge = $("#chargecreate").val();
    var charge1 = $("#chargecreatex").val();
    var survix =  parseFloat(amount)+parseFloat(charge1)+(parseFloat(amount)*parseFloat(charge)/100);
    var cur = '{{$currency->name}}';
    if(isNaN(survix) || survix<0){
      survix =0;           
    }
    var ddd = cur+' '+survix.toFixed(2);
    $("#resulttransfer6").text(ddd);
  }  
  </script>

<script type="text/javascript">
  "use strict";
  function donex(){
    var xsp = $("#xxpay").find(":selected").val();
    if(xsp==1){
      $("#subaccount").show();
    }else if(xsp==0){
      $("#subaccount").hide();
      $("#flat_share").hide();
      $("#percent_share").hide();
    }
  }
  $("#xxpay").change(donex);
  donex();  
  
  "use strict";
  function donep(){
    var spt = $("#spt").find(":selected").val();
    if(spt==1){
      $("#flat_share").show();
      $("#percent_share").hide();
    }else if(spt==2){
      $("#flat_share").hide();
      $("#percent_share").show();
    }
  }
  $("#spt").change(donep);
  donep();  
  
  "use strict";
  function countryp(){
    var pcountry = $("#xcountry").find(":selected").val();
    if(pcountry){
      $(".xbank").hide();
      $("#cbank"+pcountry).show();
    }
  }
  $("#xcountry").change(countryp);
  countryp();

  "use strict";
  function cardcharge(){
    var amount = $("#cardamount").val();
    var charge = $("#charge").val();
    var survix =  (parseFloat(amount)*parseFloat(charge)/100)+parseFloat(amount);
    var cur = '{{$currency->name}}';
    if(isNaN(survix)){
      survix =0;           
    }
    var ddd = cur+' '+survix.toFixed(2);
    $("#cardresult").text(ddd);
  }
</script>
<script type="text/javascript">
  "use strict";
  function cryptocharge(){
    var amount = $("#amountcrypto").val();
    var charge = $("#chargecrypto").val();
    var survix =  (parseFloat(amount)*parseFloat(charge)/100)+parseFloat(amount);
    var cur = '{{$currency->name}}';
    if(isNaN(survix)){
      survix =0;           
    }
    var ddd = cur+' '+survix.toFixed(2);
    $("#resultcrypto").text(ddd);
  }
</script> 
<script type="text/javascript">
  "use strict";
  function sellcrypto(){
    var amount = $("#amounttransfer").val();
    var charge = $("#chargetransfer").val();
    var rate = $("#ratetransfer").val();
    var survix =  (parseFloat(amount)*parseFloat(charge)/100)+parseFloat(amount);
    var gain =  parseFloat(amount)*parseFloat(rate);
    var cur = 'USD';
    if(isNaN(survix)){
      survix =0;           
    }    
    var curr = '{{$currency->name}}';
    if(isNaN(gain)){
      gain =0;           
    }
    var ddd = cur+' '+survix.toFixed(2);
    var fff = curr+' '+gain.toFixed(2);
    $("#gain").text(fff);
    $("#resulttransfer").text(ddd);
  } 
  
  "use strict";
  function buycrypto(){
    var amount = $("#amounttransfer1").val();
    var charge = $("#chargetransfer1").val();
    var rate = $("#ratetransfer1").val();
    var survix =  (parseFloat(amount)*parseFloat(charge)/100)+parseFloat(amount);
    var gain =  parseFloat(amount)/parseFloat(rate);
    var cur = '{{$currency->name}}';
    if(isNaN(survix)){
      survix =0;           
    }    
    var curr = 'USD';
    if(isNaN(gain)){
      gain =0;           
    }
    var ddd = cur+' '+survix.toFixed(2);
    var fff = curr+' '+gain.toFixed(2);
    $("#gain1").text(fff);
    $("#resulttransfer1").text(ddd);
  }


   "use strict";
  function transfercharge(){
    var amount = $("#amounttransfer").val();
    var charge = $("#chargetransfer").val();
    var charge1 = $("#chargetransfer1").val();
    var survix =  (parseFloat(amount)*parseFloat(charge)/100)+parseFloat(amount)+parseFloat(charge1);
    var cur = '{{$currency->name}}';
    if(isNaN(survix)){
      survix =0;           
    }
    var ddd = cur+' '+survix.toFixed(2);
    $("#resulttransfer").text(ddd);
  } 
  "use strict";
  function databundle(){
      try {
            var biller = $("#biller").find(":selected").text();
            var myarr = biller.split("-");
            var amount = myarr[1].split("<");
            var charge = $("#chargetransfer").val();
            var survix =  (parseFloat(amount)*parseFloat(charge)/100)+parseFloat(amount);
            var cur = '{{$currency->name}}';
            if(isNaN(survix)){
              survix =0;           
            }
            var ddd = cur+' '+survix.toFixed(2);
            $("#resulttransfer").text(ddd);
            $("#real").val(amount);
      } catch (e) {
          console.log(e);
      }
  }
  $("#biller").change(databundle);
  databundle();



  $(document).ready(function () {
				$(".phone-mask").inputmask({
					mask: ["(99) 9999 - 9999", "(99) 99999 - 9999"],
					keepStatic: true
				});

				$(".mobilephone-mask").inputmask({
					mask: ["(99) 9999 - 9999", "(99) 99999 - 9999"],
					keepStatic: true
				});

				$(".date-mask").inputmask({
					mask: ["99/99/9999"],
					keepStatic: true
				});

				$(".cpf-mask").inputmask({
					mask: ["999.999.999-99"],
					keepStatic: true
				});
				$(".cnpj-mask").inputmask({
					mask: ["99.999.999/9999-99"],
					keepStatic: true
				});
				$(".cep-mask").inputmask({
					mask: ["99999-999"],
					keepStatic: true
				});
				
				$('.money-mask').priceFormat({
					prefix: '',
					centsSeparator: ',',
					thousandsSeparator: '.'
				});


				$('.currency-mask').priceFormat({
					prefix: '',
					centsSeparator: ',',
					thousandsSeparator: '.',
					centsLimit: 6
				});


        $(".numeric-input").numeric();
		});
</script> 
