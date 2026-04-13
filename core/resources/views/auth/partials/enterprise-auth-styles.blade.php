<style>
  .auth-login-page {
    --sharkpay-purple: #7b16f4;
    --sharkpay-purple-dark: #5d0fd3;
    --sharkpay-purple-soft: #efe6ff;
    --sharkpay-orange: #f58a00;
    --sharkpay-orange-dark: #de7600;
    --sharkpay-ink: #1c2340;
    --sharkpay-slate: #667085;
    min-height: 100vh;
    background:
      radial-gradient(circle at top left, rgba(123, 22, 244, 0.16), transparent 32%),
      radial-gradient(circle at bottom right, rgba(245, 138, 0, 0.14), transparent 26%),
      linear-gradient(135deg, #f8f6ff 0%, #f3f5fb 42%, #fffaf4 100%);
    padding: 7rem 0 4rem;
  }

  .auth-shell {
    position: relative;
    overflow: hidden;
    border-radius: 32px;
    background: rgba(255, 255, 255, 0.92);
    box-shadow: 0 34px 90px rgba(49, 27, 93, 0.16);
    border: 1px solid rgba(123, 22, 244, 0.08);
  }

  .auth-shell::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.08), transparent 32%);
    pointer-events: none;
  }

  .auth-showcase {
    position: relative;
    min-height: 100%;
    padding: 3.5rem;
    color: #fff;
    background:
      linear-gradient(170deg, rgba(39, 14, 84, 0.18), rgba(28, 35, 64, 0.12)),
      linear-gradient(145deg, #5610c7 0%, #7b16f4 48%, #f58a00 100%);
  }

  .auth-showcase::before {
    content: "";
    position: absolute;
    inset: 0;
    background:
      linear-gradient(120deg, rgba(255, 255, 255, 0.06), transparent 36%),
      url("{{ url('/') }}/asset/images/abstract-shapes-20.svg") right center / cover no-repeat;
    opacity: .38;
    pointer-events: none;
  }

  .auth-showcase::after {
    content: "";
    position: absolute;
    right: -5rem;
    bottom: -6rem;
    width: 16rem;
    height: 16rem;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    filter: blur(1px);
  }

  .auth-brand-mark {
    display: inline-flex;
    align-items: center;
    gap: .75rem;
    padding: .55rem 1rem;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.16);
    backdrop-filter: blur(12px);
    font-size: .85rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
  }

  .auth-brand-mark i {
    font-size: 1rem;
  }

  .auth-showcase-title {
    font-size: 2.7rem;
    line-height: 1.05;
    font-weight: 800;
    letter-spacing: -.04em;
    margin-bottom: 1.1rem;
  }

  .auth-showcase-copy {
    max-width: 32rem;
    color: rgba(255, 255, 255, 0.84);
    font-size: 1rem;
    line-height: 1.75;
    margin-bottom: 2rem;
  }

  .auth-showcase-stats {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: .9rem;
    margin: 0 0 2rem;
  }

  .auth-stat-card {
    padding: 1rem 1rem 1.05rem;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(14px);
  }

  .auth-stat-card strong {
    display: block;
    font-size: 1.05rem;
    font-weight: 800;
  }

  .auth-stat-card span {
    display: block;
    margin-top: .3rem;
    color: rgba(255, 255, 255, 0.74);
    font-size: .8rem;
    line-height: 1.45;
  }

  .auth-feature-list {
    display: grid;
    gap: 1rem;
    margin: 0;
    padding: 0;
    list-style: none;
  }

  .auth-feature-item {
    display: flex;
    gap: .9rem;
    align-items: flex-start;
    padding: 1rem 1.1rem;
    border-radius: 18px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
  }

  .auth-feature-icon {
    width: 2.4rem;
    height: 2.4rem;
    border-radius: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.18);
    flex: 0 0 auto;
  }

  .auth-feature-item strong {
    display: block;
    margin-bottom: .25rem;
    font-size: .95rem;
  }

  .auth-feature-item span {
    color: rgba(255, 255, 255, 0.74);
    font-size: .88rem;
    line-height: 1.5;
  }

  .auth-panel {
    padding: 3.5rem 3rem;
    position: relative;
    z-index: 1;
  }

  .auth-panel-header {
    margin-bottom: 1.8rem;
  }

  .auth-panel-logo {
    max-width: 240px;
    width: 100%;
    height: auto;
    display: block;
    margin-bottom: 1.35rem;
  }

  .auth-panel-topline {
    display: inline-flex;
    align-items: center;
    gap: .55rem;
    padding: .45rem .85rem;
    border-radius: 999px;
    background: var(--sharkpay-purple-soft);
    color: var(--sharkpay-purple-dark);
    font-size: .78rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    margin-bottom: 1.15rem;
  }

  .auth-panel h1 {
    color: var(--sharkpay-ink);
    font-size: 2.15rem;
    font-weight: 800;
    letter-spacing: -.04em;
    margin-bottom: .75rem;
  }

  .auth-panel-subtitle {
    color: var(--sharkpay-slate);
    line-height: 1.7;
    margin-bottom: 2rem;
  }

  .auth-panel-subtitle strong {
    color: var(--sharkpay-purple-dark);
  }

  .auth-form-grid {
    display: grid;
    gap: 1rem;
  }

  .auth-form-grid--two {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }

  .auth-field-label {
    display: block;
    margin-bottom: .55rem;
    color: #344054;
    font-size: .87rem;
    font-weight: 700;
  }

  .auth-input-group,
  .auth-select {
    display: flex;
    align-items: stretch;
    border-radius: 18px;
    background: #f8fafc;
    border: 1px solid #dbe3ee;
    overflow: hidden;
    transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
  }

  .auth-input-group:focus-within,
  .auth-select:focus {
    border-color: rgba(123, 22, 244, 0.45);
    box-shadow: 0 0 0 4px rgba(123, 22, 244, 0.12);
    transform: translateY(-1px);
  }

  .auth-input-icon,
  .auth-password-toggle {
    width: 3.25rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #667085;
    background: transparent;
    border: 0;
    padding: 0;
  }

  .auth-password-toggle {
    cursor: pointer;
  }

  .auth-password-toggle:focus {
    outline: none;
  }

  .auth-input-group .form-control,
  .auth-select {
    height: 3.5rem;
    border: 0;
    background: transparent !important;
    color: #0f172a !important;
    box-shadow: none !important;
  }

  .auth-input-group .form-control {
    padding: 0 1rem 0 0;
  }

  .auth-select {
    width: 100%;
    padding: 0 1rem;
    appearance: none;
  }

  .auth-input-group .form-control::placeholder {
    color: #98a2b3;
  }

  .auth-inline-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin: 1rem 0 1.6rem;
  }

  .auth-inline-row .custom-control-label,
  .auth-legal {
    color: #344054;
    font-size: .92rem;
    line-height: 1.7;
  }

  .auth-inline-row a,
  .auth-legal a,
  .auth-link-inline {
    color: var(--sharkpay-purple-dark);
    font-weight: 700;
  }

  .auth-inline-row a:hover,
  .auth-legal a:hover,
  .auth-link-inline:hover {
    color: var(--sharkpay-orange-dark);
    text-decoration: none;
  }

  .auth-primary-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .65rem;
    width: 100%;
    min-height: 3.6rem;
    border: 0;
    border-radius: 18px;
    background: linear-gradient(135deg, var(--sharkpay-purple-dark) 0%, var(--sharkpay-purple) 62%, #9a3cff 100%);
    box-shadow: 0 18px 34px rgba(123, 22, 244, 0.24);
    color: #fff;
    font-size: .95rem;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
    transition: transform .2s ease, box-shadow .2s ease;
  }

  .auth-primary-btn:hover {
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 22px 40px rgba(123, 22, 244, 0.3);
  }

  .auth-divider {
    position: relative;
    text-align: center;
    margin: 1.6rem 0;
  }

  .auth-divider::before {
    content: "";
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    border-top: 1px solid #e4e7ec;
  }

  .auth-divider span {
    position: relative;
    display: inline-block;
    padding: 0 .9rem;
    background: #fff;
    color: #98a2b3;
    font-size: .76rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
  }

  .auth-secondary-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .6rem;
    width: 100%;
    min-height: 3.35rem;
    border: 1px solid #d0d9e5;
    border-radius: 18px;
    background: #fff;
    color: var(--sharkpay-orange-dark);
    font-size: .92rem;
    font-weight: 800;
    letter-spacing: .05em;
    text-transform: uppercase;
    transition: border-color .2s ease, background-color .2s ease;
  }

  .auth-secondary-btn:hover {
    text-decoration: none;
    color: var(--sharkpay-purple-dark);
    border-color: rgba(245, 138, 0, 0.35);
    background: #fff8ef;
  }

  .auth-error {
    display: block;
    margin-top: .6rem;
    color: #d92d20;
    font-size: .82rem;
    font-weight: 700;
  }

  .auth-helper-text {
    display: block;
    margin-top: .55rem;
    color: #667085;
    font-size: .82rem;
  }

  .auth-panel-footer {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #eaecf0;
    color: var(--sharkpay-slate);
    font-size: .92rem;
    line-height: 1.7;
  }

  .auth-panel-footer strong {
    color: var(--sharkpay-ink);
  }

  @media (max-width: 991.98px) {
    .auth-login-page {
      padding: 6rem 0 3rem;
    }

    .auth-shell {
      border-radius: 26px;
    }

    .auth-showcase,
    .auth-panel {
      padding: 2.2rem;
    }

    .auth-showcase-title {
      font-size: 2.2rem;
    }

    .auth-showcase-stats,
    .auth-form-grid--two {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 767.98px) {
    .auth-login-page {
      padding: 5.4rem 0 2rem;
    }

    .auth-shell {
      border-radius: 22px;
    }

    .auth-showcase {
      padding-bottom: 2rem;
    }

    .auth-showcase-title {
      font-size: 1.9rem;
    }

    .auth-panel {
      padding-top: 2rem;
    }

    .auth-inline-row {
      flex-direction: column;
      align-items: flex-start;
    }
  }
</style>