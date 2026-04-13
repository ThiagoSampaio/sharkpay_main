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
            'badgeIcon' => 'fas fa-user-plus',
            'badgeText' => 'SharkPay Onboarding',
            'title' => 'Cadastro com linguagem visual mais madura para clientes e operações empresariais.',
            'copy' => 'A abertura de conta agora acompanha a identidade SharkPay com uma apresentação mais profissional, transmitindo credibilidade desde o primeiro contato do usuário com a plataforma.',
            'stats' => [
              ['title' => 'Structured Signup', 'text' => 'Cadastro organizado para reduzir ruído e aumentar a clareza do processo.'],
              ['title' => 'Corporate Positioning', 'text' => 'Comunicação visual mais adequada para empresas e times financeiros.'],
              ['title' => 'Brand Alignment', 'text' => 'Logo, cores e hierarquia consistentes com a marca SharkPay.'],
            ],
            'features' => [
              ['icon' => 'fas fa-building', 'title' => 'Entrada institucional', 'text' => 'A jornada de onboarding passa a parecer parte de uma plataforma financeira consolidada.'],
              ['icon' => 'fas fa-id-card', 'title' => 'Coleta mais clara', 'text' => 'Os campos principais foram reorganizados para facilitar o preenchimento e a leitura.'],
              ['icon' => 'fas fa-shield-alt', 'title' => 'Mais confiança', 'text' => 'A apresentação visual reforça segurança, consistência e preparo para expansão do fluxo.'],
            ],
          ])
        </div>

        <div class="col-lg-6 d-flex">
          <section class="auth-panel w-100 d-flex flex-column justify-content-center">
            <div class="auth-panel-header">
              <img src="{{ url('/') }}/asset/images/logo_1735389067.png" alt="SharkPay" class="auth-panel-logo">

              <div class="auth-panel-topline">
                <i class="fas fa-user-plus"></i>
                <span>Cadastro SharkPay</span>
              </div>
            </div>

            <h1>Crie sua conta</h1>
            <p class="auth-panel-subtitle"><strong>Onboarding com identidade corporativa</strong> para manter o padrão visual SharkPay em toda a jornada de autenticação.</p>

            <form role="form" action="{{route('submitregister')}}" method="post">
              @csrf

              <div class="auth-form-grid">
                <div class="form-group mb-0">
                  <label class="auth-field-label" for="register-business-name">{{$lang["regiter_business_name"]}}</label>
                  <div class="auth-input-group">
                    <span class="auth-input-icon"><i class="fas fa-briefcase"></i></span>
                    <input id="register-business-name" class="form-control" placeholder="{{$lang["regiter_business_name"]}}" type="text" name="business_name" value="{{ old('business_name') }}" required>
                  </div>
                  @if ($errors->has('business_name'))
                    <span class="auth-error">{{$errors->first('business_name')}}</span>
                  @endif
                </div>

                <div class="auth-form-grid auth-form-grid--two">
                  <div class="form-group mb-0">
                    <label class="auth-field-label" for="register-first-name">{{$lang["regiter_first_name"]}}</label>
                    <div class="auth-input-group">
                      <span class="auth-input-icon"><i class="fas fa-user"></i></span>
                      <input id="register-first-name" class="form-control" placeholder="{{$lang["regiter_first_name"]}}" type="text" name="first_name" value="{{ old('first_name') }}" required>
                    </div>
                  </div>

                  <div class="form-group mb-0">
                    <label class="auth-field-label" for="register-last-name">{{$lang["regiter_last_name"]}}</label>
                    <div class="auth-input-group">
                      <span class="auth-input-icon"><i class="fas fa-user"></i></span>
                      <input id="register-last-name" class="form-control" placeholder="{{$lang["regiter_last_name"]}}" type="text" name="last_name" value="{{ old('last_name') }}" required>
                    </div>
                  </div>
                </div>

                <div class="auth-form-grid auth-form-grid--two">
                  <div class="form-group mb-0">
                    <label class="auth-field-label" for="register-email">{{$lang["regiter_email"]}}</label>
                    <div class="auth-input-group">
                      <span class="auth-input-icon"><i class="fas fa-envelope"></i></span>
                      <input id="register-email" class="form-control" placeholder="{{$lang["regiter_email"]}}" type="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    @if ($errors->has('email'))
                      <span class="auth-error">{{$errors->first('email')}}</span>
                    @endif
                  </div>

                  <div class="form-group mb-0">
                    <label class="auth-field-label" for="register-phone">{{$lang["regiter_mobile"]}}</label>
                    <div class="auth-input-group">
                      <span class="auth-input-icon"><i class="fas fa-phone-alt"></i></span>
                      <input id="register-phone" class="form-control" placeholder="{{$lang["regiter_mobile"]}}" type="number" name="phone" value="{{ old('phone') }}" required>
                    </div>
                    @if ($errors->has('phone'))
                      <span class="auth-error">{{$errors->first('phone')}}</span>
                    @endif
                  </div>
                </div>

                <div class="form-group mb-0">
                  <label class="auth-field-label" for="country">{{$lang["regiter_select_country"]}}</label>
                  <select id="country" class="auth-select" name="country" required>
                    <option value="">{{$lang["regiter_select_country"]}}</option>
                    @foreach($country as $val)
                      <option value="{{$val->country_id}}" {{ old('country') == $val->country_id ? 'selected' : '' }}>{{$val->real['nicename']}}</option>
                    @endforeach
                  </select>
                  @if ($errors->has('country'))
                    <span class="auth-error">{{$errors->first('country')}}</span>
                  @endif
                </div>

                <div class="form-group mb-0">
                  <label class="auth-field-label" for="register-password">{{$lang["regiter_password"]}}</label>
                  <div class="auth-input-group">
                    <span class="auth-input-icon"><i class="fas fa-key"></i></span>
                    <input id="register-password" class="form-control" placeholder="{{$lang["regiter_password"]}}" type="password" name="password" required>
                    <button type="button" class="auth-password-toggle" id="toggle-register-password" aria-label="Mostrar senha">
                      <i class="fas fa-eye"></i>
                    </button>
                  </div>
                  @if ($errors->has('password'))
                    <span class="auth-error">{{$errors->first('password')}}</span>
                  @endif
                  <span class="auth-helper-text">Defina uma senha forte para proteger o acesso da conta empresarial.</span>
                </div>

                <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" id="register-terms" type="checkbox" required>
                  <label class="custom-control-label auth-legal" for="register-terms">
                    <span>{{$lang["regiter_agree_to"]}} <a href="{{route('terms')}}">{{$lang["regiter_terms_and_conditions"]}}</a> @if($set->stripe_connect==1) {{$lang["regiter_and_the"]}} <a href="https://stripe.com/connect-account/legal/full">{{$lang["regiter_stripe_connected_account_agreement"]}}</a>@endif</span>
                  </label>
                </div>

                @if($set->recaptcha==1)
                  <div>
                    {!! app('captcha')->display() !!}
                    @if ($errors->has('g-recaptcha-response'))
                      <span class="auth-error">{{ $errors->first('g-recaptcha-response') }}</span>
                    @endif
                  </div>
                @endif
              </div>

              <button type="submit" class="auth-primary-btn mt-4">
                <i class="fas fa-user-plus"></i>
                <span>{{$lang["regiter_create_account"]}}</span>
              </button>

              <div class="auth-divider">
                <span>{{$lang["regiter_or"]}}</span>
              </div>

              <a href="{{route('login')}}" class="auth-secondary-btn">
                <i class="fas fa-right-to-bracket"></i>
                <span>{{$lang["regiter_got_an_account"]}}</span>
              </a>
            </form>

            <div class="auth-panel-footer">
              <strong>SharkPay</strong><br>
              Cadastro com posicionamento visual mais profissional, consistente com a marca e preparado para evoluir o onboarding da plataforma.
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
    var toggleButton = document.getElementById('toggle-register-password');
    var passwordInput = document.getElementById('register-password');

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