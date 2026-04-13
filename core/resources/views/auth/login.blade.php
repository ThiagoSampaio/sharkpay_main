@extends('loginlayout')

@section('css')
@include('auth.partials.enterprise-auth-styles')
@stop

@section('content')
<div class="main-content auth-login-page">
  <div class="container">
    <div class="auth-shell">
      <div class="row no-gutters align-items-stretch">
        <div class="col-lg-6 d-flex">
          @include('auth.partials.enterprise-auth-showcase', [
            'badgeIcon' => 'fas fa-building',
            'badgeText' => 'SharkPay for Enterprise',
            'title' => 'Infraestrutura de pagamentos com presença mais sólida, corporativa e confiável.',
            'copy' => 'A experiência de acesso foi redesenhada para refletir a identidade da SharkPay e transmitir mais confiança para operações empresariais, times financeiros e ambientes com alto volume.',
            'stats' => [
              ['title' => 'Enterprise Ready', 'text' => 'Entrada compatível com uma operação de pagamentos profissional.'],
              ['title' => 'Brand Consistency', 'text' => 'Visual roxo e laranja alinhado à identidade SharkPay.'],
              ['title' => 'Secure Access', 'text' => 'Foco visual em credibilidade, clareza e confiança operacional.'],
            ],
            'features' => [
              ['icon' => 'fas fa-chart-line', 'title' => 'Apresentação corporativa', 'text' => 'Uma tela de entrada mais adequada para clientes empresariais e operações financeiras sérias.'],
              ['icon' => 'fas fa-shield-alt', 'title' => 'Confiança visual', 'text' => 'Cores, contraste e hierarquia preparados para comunicar segurança já no primeiro contato.'],
              ['icon' => 'fas fa-briefcase', 'title' => 'Experiência mais madura', 'text' => 'Layout com linguagem mais profissional para futuras expansões em cadastro, recuperação e painel.'],
            ],
          ])
        </div>

        <div class="col-lg-6 d-flex">
          <section class="auth-panel w-100 d-flex flex-column justify-content-center">
            <div class="auth-panel-header">
              <img src="{{ url('/') }}/asset/images/logo_1735389067.png" alt="SharkPay" class="auth-panel-logo">

              <div class="auth-panel-topline">
                <i class="fas fa-fingerprint"></i>
                <span>Acesso SharkPay</span>
              </div>
            </div>

            <h1>Entre na sua conta</h1>
            <p class="auth-panel-subtitle"><strong>Login corporativo</strong> com identidade visual SharkPay, pensado para uma experiência mais robusta e adequada a empresas.</p>

            <form role="form" action="{{route('submitlogin')}}" method="post">
              @csrf

              <div class="form-group mb-3">
                <label class="auth-field-label" for="login-email">{{$lang["login_email"]}}</label>
                <div class="auth-input-group">
                  <span class="auth-input-icon"><i class="fas fa-envelope"></i></span>
                  <input id="login-email" class="form-control" placeholder="{{$lang["login_email"]}}" type="email" name="email" value="{{ old('email') }}" required>
                </div>
                @if ($errors->has('email'))
                  <span class="auth-error">{{ $errors->first('email') }}</span>
                @endif
              </div>

              <div class="form-group mb-2">
                <label class="auth-field-label" for="login-password">{{$lang["login_password"]}}</label>
                <div class="auth-input-group">
                  <span class="auth-input-icon"><i class="fas fa-key"></i></span>
                  <input id="login-password" class="form-control" placeholder="{{$lang["login_password"]}}" type="password" name="password" required>
                  <button type="button" class="auth-password-toggle" id="toggle-login-password" aria-label="Mostrar senha">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
                @if ($errors->has('password'))
                  <span class="auth-error">{{ $errors->first('password') }}</span>
                @endif
              </div>

              <div class="auth-inline-row">
                <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" id="remember-login" type="checkbox" name="remember_me">
                  <label class="custom-control-label" for="remember-login">
                    <span>{{$lang["login_remember_me"]}}</span>
                  </label>
                </div>

                <a href="{{route('user.password.request')}}">{{$lang["login_forgot_password"]}}</a>
              </div>

              @if($set->recaptcha==1)
                <div class="mb-3">
                  {!! app('captcha')->display() !!}
                  @if ($errors->has('g-recaptcha-response'))
                    <span class="auth-error">{{ $errors->first('g-recaptcha-response') }}</span>
                  @endif
                </div>
              @endif

              <button type="submit" class="auth-primary-btn">
                <i class="fas fa-right-to-bracket"></i>
                <span>Entrar</span>
              </button>

              <div class="auth-divider">
                <span>ou</span>
              </div>

              <a href="{{route('register')}}" class="auth-secondary-btn">
                <i class="fas fa-user-plus"></i>
                <span>{{$lang["login_create_an_account"]}}</span>
              </a>
            </form>

            <div class="auth-panel-footer">
              <strong>SharkPay</strong><br>
              Plataforma de pagamentos com linguagem visual mais profissional, consistente e preparada para ambiente enterprise.
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
</div>
@stop

@section('script')
<script>
  (function () {
    var toggleButton = document.getElementById('toggle-login-password');
    var passwordInput = document.getElementById('login-password');

    if (!toggleButton || !passwordInput) {
      return;
    }

    toggleButton.addEventListener('click', function () {
      var showingPassword = passwordInput.getAttribute('type') === 'text';
      passwordInput.setAttribute('type', showingPassword ? 'password' : 'text');
      toggleButton.innerHTML = showingPassword
        ? '<i class="fas fa-eye"></i>'
        : '<i class="fas fa-eye-slash"></i>';
    });
  })();
</script>
@stop