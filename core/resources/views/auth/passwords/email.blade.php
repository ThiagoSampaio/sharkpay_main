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
            'badgeIcon' => 'fas fa-envelope-open-text',
            'badgeText' => 'Account Recovery',
            'title' => 'Recuperação de acesso com apresentação mais confiável e alinhada à SharkPay.',
            'copy' => 'Mesmo nas etapas de suporte e recuperação, a interface agora comunica consistência de marca, cuidado visual e uma postura mais adequada para operações empresariais.',
            'stats' => [
              ['title' => 'Clear Guidance', 'text' => 'Fluxo direto para solicitar o envio do link de recuperação.'],
              ['title' => 'Professional Tone', 'text' => 'Interface com mais credibilidade para processos sensíveis de acesso.'],
              ['title' => 'Unified Experience', 'text' => 'A mesma linguagem visual do login e do cadastro.'],
            ],
            'features' => [
              ['icon' => 'fas fa-envelope', 'title' => 'Reenvio simples', 'text' => 'O usuário informa o e-mail e continua o processo de redefinição sem fricção visual.'],
              ['icon' => 'fas fa-shield-alt', 'title' => 'Mais segurança percebida', 'text' => 'A recuperação de senha ganha uma apresentação mais séria e mais confiável.'],
              ['icon' => 'fas fa-layer-group', 'title' => 'Consistência operacional', 'text' => 'O fluxo de suporte passa a seguir o mesmo padrão SharkPay do restante da autenticação.'],
            ],
          ])
        </div>

        <div class="col-lg-6 d-flex">
          <section class="auth-panel w-100 d-flex flex-column justify-content-center">
            <div class="auth-panel-header">
              <img src="{{ url('/') }}/asset/images/logo_1735389067.png" alt="SharkPay" class="auth-panel-logo">

              <div class="auth-panel-topline">
                <i class="fas fa-life-ring"></i>
                <span>Recuperação SharkPay</span>
              </div>
            </div>

            <h1>{{$lang["email_forgot_password"]}}</h1>
            <p class="auth-panel-subtitle"><strong>Solicite um novo acesso</strong> com uma interface mais profissional e consistente com o padrão enterprise da SharkPay.</p>

            <form role="form" action="{{route('user.password.email')}}" method="post">
              @csrf

              <div class="form-group mb-0">
                <label class="auth-field-label" for="recovery-email">{{$lang["email_email_address"]}}</label>
                <div class="auth-input-group">
                  <span class="auth-input-icon"><i class="fas fa-envelope"></i></span>
                  <input id="recovery-email" class="form-control" placeholder="{{$lang["email_email_address"]}}" type="email" name="email" value="{{ old('email') }}" required>
                </div>
                @if ($errors->has('email'))
                  <span class="auth-error">{{$errors->first('email')}}</span>
                @endif
              </div>

              <button type="submit" class="auth-primary-btn mt-4">
                <i class="fas fa-paper-plane"></i>
                <span>{{$lang["email_reset_password"]}}</span>
              </button>

              <div class="auth-divider">
                <span>ou</span>
              </div>

              <a href="{{route('login')}}" class="auth-secondary-btn">
                <i class="fas fa-right-to-bracket"></i>
                <span>{{$lang["email_sign_in"]}}</span>
              </a>
            </form>

            <div class="auth-panel-footer">
              <strong>SharkPay</strong><br>
              Recuperação de acesso com visual padronizado, reforçando segurança e consistência em todas as etapas do login.
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
</div>
@stop