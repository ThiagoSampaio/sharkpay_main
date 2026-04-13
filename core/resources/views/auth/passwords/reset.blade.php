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
            'badgeIcon' => 'fas fa-key',
            'badgeText' => 'Password Reset',
            'title' => 'Redefinição de senha com experiência visual mais estável, clara e corporativa.',
            'copy' => 'A etapa de criação de nova senha agora acompanha a mesma linguagem de marca da SharkPay, reduzindo a sensação de telas isoladas e melhorando a percepção de produto sólido.',
            'stats' => [
              ['title' => 'Secure Step', 'text' => 'Tela de redefinição com foco em confiança e simplicidade.'],
              ['title' => 'Consistent Design', 'text' => 'Visual conectado ao login, cadastro e recuperação.'],
              ['title' => 'Enterprise Feel', 'text' => 'Apresentação mais séria para etapas críticas da conta.'],
            ],
            'features' => [
              ['icon' => 'fas fa-lock', 'title' => 'Nova senha com clareza', 'text' => 'O formulário foi reorganizado para tornar a atualização mais simples e mais legível.'],
              ['icon' => 'fas fa-eye', 'title' => 'Apoio à usabilidade', 'text' => 'O usuário pode visualizar a senha digitada antes de concluir a redefinição.'],
              ['icon' => 'fas fa-building', 'title' => 'Padrão institucional', 'text' => 'A redefinição segue a mesma linguagem corporativa aplicada no restante do auth.'],
            ],
          ])
        </div>

        <div class="col-lg-6 d-flex">
          <section class="auth-panel w-100 d-flex flex-column justify-content-center">
            <div class="auth-panel-header">
              <img src="{{ url('/') }}/asset/images/logo_1735389067.png" alt="SharkPay" class="auth-panel-logo">

              <div class="auth-panel-topline">
                <i class="fas fa-key"></i>
                <span>Nova senha</span>
              </div>
            </div>

            <h1>{{$lang["reset_recoer_your_account"]}}</h1>
            <p class="auth-panel-subtitle"><strong>Defina uma nova credencial</strong> mantendo o mesmo padrão visual SharkPay em todo o fluxo de autenticação.</p>

            <form role="form" action="{{route('user.password.request')}}" method="post">
              @csrf

              <div class="auth-form-grid">
                <div class="form-group mb-0">
                  <label class="auth-field-label" for="reset-email">{{$lang["reset_email"]}}</label>
                  <div class="auth-input-group">
                    <span class="auth-input-icon"><i class="fas fa-envelope"></i></span>
                    <input id="reset-email" class="form-control" placeholder="{{$lang["reset_email"]}}" type="email" name="email" value="{{ old('email') }}" required>
                  </div>
                  @if ($errors->has('email'))
                    <span class="auth-error"><strong>{{ $errors->first('email') }}</strong></span>
                  @endif
                </div>

                <div class="form-group mb-0">
                  <label class="auth-field-label" for="reset-password">{{$lang["reset_password"]}}</label>
                  <div class="auth-input-group">
                    <span class="auth-input-icon"><i class="fas fa-key"></i></span>
                    <input id="reset-password" class="form-control" placeholder="{{$lang["reset_password"]}}" type="password" name="password" required>
                    <button type="button" class="auth-password-toggle" id="toggle-reset-password" aria-label="Mostrar senha">
                      <i class="fas fa-eye"></i>
                    </button>
                  </div>
                  @if ($errors->has('password'))
                    <span class="auth-error"><strong>{{ $errors->first('password') }}</strong></span>
                  @endif
                </div>
              </div>

              <input type="hidden" name="token" value="{{ $token }}">

              <button type="submit" class="auth-primary-btn mt-4">
                <i class="fas fa-sync-alt"></i>
                <span>{{$lang["reset_continue"]}}</span>
              </button>

              <div class="auth-divider">
                <span>{{$lang["reset_or"]}}</span>
              </div>

              <a href="{{route('login')}}" class="auth-secondary-btn">
                <i class="fas fa-right-to-bracket"></i>
                <span>{{$lang["reset_sign_in"]}}</span>
              </a>
            </form>

            <div class="auth-panel-footer">
              <strong>SharkPay</strong><br>
              Redefinição de senha integrada à nova linguagem visual enterprise para manter o fluxo de autenticação mais coeso e confiável.
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
    var toggleButton = document.getElementById('toggle-reset-password');
    var passwordInput = document.getElementById('reset-password');

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