<section class="auth-showcase w-100 d-flex flex-column justify-content-between">
  <div>
    <div class="auth-brand-mark">
      <i class="{{ $badgeIcon ?? 'fas fa-building' }}"></i>
      <span>{{ $badgeText ?? 'SharkPay for Enterprise' }}</span>
    </div>

    <h2 class="auth-showcase-title">{{ $title }}</h2>
    <p class="auth-showcase-copy">{{ $copy }}</p>

    @if (!empty($stats))
      <div class="auth-showcase-stats">
        @foreach ($stats as $stat)
          <div class="auth-stat-card">
            <strong>{{ $stat['title'] }}</strong>
            <span>{{ $stat['text'] }}</span>
          </div>
        @endforeach
      </div>
    @endif
  </div>

  @if (!empty($features))
    <ul class="auth-feature-list">
      @foreach ($features as $feature)
        <li class="auth-feature-item">
          <span class="auth-feature-icon"><i class="{{ $feature['icon'] }}"></i></span>
          <div>
            <strong>{{ $feature['title'] }}</strong>
            <span>{{ $feature['text'] }}</span>
          </div>
        </li>
      @endforeach
    </ul>
  @endif
</section>