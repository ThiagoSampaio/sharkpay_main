@extends('loginlayout')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');

  * {
    font-family: "Inter", sans-serif ;
    line-height:1.25rem;
  }
  @media (max-width: 768px) {
    .hide-on-mobile {
      display: none;
    }
  }
</style>
<div class="main-content">
    <!-- Header -->
    <div class="header py-5 pt-7">
      <div class="container">
        <div class="header-body text-center ">
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 hide-on-mobile">
          <img src="{{asset('asset/payment_gateways/bgpay.svg')}}" class="mt-5 pt-5" style="width:100%;">
        </div>
        <div class="col-lg-6 col-md-8">
          <div class="card border-0 mb-0" style="background-color: #f7fafc !important;">
            <div class="card-header bg-transparent pb-3">
              <div class="card-profile-image mb-5">
              </div>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
              <div class="text-center text-dark mb-5">
                <img src="https://sharkpay.com.br/asset/images/logo_1735389067.png" width="80%;" class="mb-3">
                <h1 class="text-dark font-weight-bolder" style="color: #000 !important;">{{ __('Sign In') }}</h1>
                <small style="color: #aaa !important;">{{ __('Welcome back, login to manage account') }}</small>
              </div>
              <form role="form" action="{{route('admin.login')}}" method="post">
                @csrf
                <div class="form-group mb-3">
                  <div class="input-group">
                    <div class="input-group-prepend" style="background-color: transparent !important;">
                      <span class="input-group-text"><i class="fad fa-envelope"></i></span>
                    </div>
                    <input style="background-color:#efefef !important; color:#000 !important" class="form-control" placeholder="{{ __('Username') }}" type="text" name="username" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend" style="background-color: transparent !important;">
                      <span class="input-group-text"><i class="fad fa-unlock"></i></span>
                    </div>
                    <input style="background-color:#efefef !important; color:#000 !important" class="form-control" placeholder="{{ __('Password') }}" type="password" name="password" required>
                  </div>
                </div>
                <div class="custom-control custom-control-alternative custom-checkbox">
                  <input style="background-color:#efefef !important; color:#000 !important" class="custom-control-input" id=" customCheckLogin" type="checkbox" name="remember_me">
                  <label class="custom-control-label" for=" customCheckLogin">
                    <span class="text-dark" style="color: #000 !important;">{{__('Remember me')}}</span>
                  </label>
                </div>                
                <div class="text-center">
                  <button type="submit" class="btn btn-neutral my-4 btn-block">LOGIN</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
@stop