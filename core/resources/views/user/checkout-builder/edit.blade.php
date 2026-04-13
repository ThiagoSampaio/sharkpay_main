@extends('userlayout')

@section('content')
<div class="container-fluid">
    <div class="header pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6">
                        <h1 class="display-4 text-white">Editar Checkout</h1>
                        <p class="text-light">Atualize as configurações do seu checkout</p>
                    </div>
                    <div class="col-lg-6 text-right">
                        <a href="{{ route('user.checkout-builder.index') }}" class="btn btn-neutral">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                        <a href="{{ $checkout->checkout_url }}" target="_blank" class="btn btn-info">
                            <i class="fas fa-external-link-alt"></i> Preview
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <form action="{{ route('user.checkout-builder.update', $checkout->id) }}" method="POST" id="checkout-form">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Informações Básicas -->
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0">Informações Básicas</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-control-label">Nome do Checkout *</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $checkout->name) }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">Descrição</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                          rows="3">{{ old('description', $checkout->description) }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="active" {{ $checkout->status == 'active' ? 'selected' : '' }}>Ativo</option>
                                    <option value="inactive" {{ $checkout->status == 'inactive' ? 'selected' : '' }}>Inativo</option>
                                    <option value="draft" {{ $checkout->status == 'draft' ? 'selected' : '' }}>Rascunho</option>
                                </select>
                            </div>

                            <hr>
                            <h4 class="mb-3">Configuração do Funil</h4>

                            <div class="form-group">
                                <label class="form-control-label">Produto Principal *</label>
                                <select name="funnel_config[main_product]" class="form-control" required>
                                    <option value="">Selecione o produto principal</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                            {{ old('funnel_config.main_product', $checkout->funnel_config['main_product'] ?? '') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} - R$ {{ number_format($product->amount, 2, ',', '.') }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">URL de Redirecionamento (Sucesso)</label>
                                <input type="url" name="funnel_config[success_url]" class="form-control"
                                       value="{{ old('funnel_config.success_url', $checkout->funnel_config['success_url'] ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">URL de Redirecionamento (Cancelamento)</label>
                                <input type="url" name="funnel_config[cancel_url]" class="form-control"
                                       value="{{ old('funnel_config.cancel_url', $checkout->funnel_config['cancel_url'] ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Upsell/Downsell -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="mb-0">Configuração de Upsell/Downsell</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-control-label">Produtos Upsell</label>
                                <select name="upsell_products[]" class="form-control" multiple style="height: 120px;">
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                            {{ in_array($product->id, $checkout->upsell_products ?? []) ? 'selected' : '' }}>
                                        {{ $product->name }} - R$ {{ number_format($product->amount, 2, ',', '.') }}
                                    </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Segure Ctrl/Cmd para selecionar múltiplos produtos</small>
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">Produtos Downsell</label>
                                <select name="downsell_products[]" class="form-control" multiple style="height: 120px;">
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                            {{ in_array($product->id, $checkout->downsell_products ?? []) ? 'selected' : '' }}>
                                        {{ $product->name }} - R$ {{ number_format($product->amount, 2, ',', '.') }}
                                    </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Produtos oferecidos caso o cliente recuse o upsell</small>
                            </div>
                        </div>
                    </div>

                    <!-- Aparência -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="mb-0">Personalização Visual</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Cor Primária</label>
                                        <input type="color" name="theme_config[primary_color]" class="form-control"
                                               value="{{ old('theme_config.primary_color', $checkout->theme_config['primary_color'] ?? '#007bff') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Cor Secundária</label>
                                        <input type="color" name="theme_config[secondary_color]" class="form-control"
                                               value="{{ old('theme_config.secondary_color', $checkout->theme_config['secondary_color'] ?? '#6c757d') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Layout</label>
                                        <select name="theme_config[layout]" class="form-control">
                                            <option value="single-column" {{ ($checkout->theme_config['layout'] ?? '') == 'single-column' ? 'selected' : '' }}>Coluna Única</option>
                                            <option value="two-column" {{ ($checkout->theme_config['layout'] ?? '') == 'two-column' ? 'selected' : '' }}>Duas Colunas</option>
                                            <option value="minimal" {{ ($checkout->theme_config['layout'] ?? '') == 'minimal' ? 'selected' : '' }}>Minimalista</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Estilo dos Botões</label>
                                        <select name="theme_config[button_style]" class="form-control">
                                            <option value="rounded" {{ ($checkout->theme_config['button_style'] ?? '') == 'rounded' ? 'selected' : '' }}>Arredondado</option>
                                            <option value="square" {{ ($checkout->theme_config['button_style'] ?? '') == 'square' ? 'selected' : '' }}>Quadrado</option>
                                            <option value="pill" {{ ($checkout->theme_config['button_style'] ?? '') == 'pill' ? 'selected' : '' }}>Pílula</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">URL do Logo (opcional)</label>
                                <input type="url" name="logo_url" class="form-control"
                                       value="{{ old('logo_url', $checkout->logo_url) }}">
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">CSS Personalizado (opcional)</label>
                                <textarea name="custom_css" class="form-control" rows="5">{{ old('custom_css', $checkout->custom_css) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Estatísticas -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="mb-0">Estatísticas do Checkout</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <h3>{{ $checkout->total_orders }}</h3>
                                        <p class="text-muted">Total de Pedidos</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <h3>R$ {{ number_format($checkout->total_revenue, 2, ',', '.') }}</h3>
                                        <p class="text-muted">Receita Total</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <h3>{{ $checkout->conversion_rate_formatted ?? '0%' }}</h3>
                                        <p class="text-muted">Taxa de Conversão</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Configurações Laterais -->
                <div class="col-xl-4">
                    <!-- Métodos de Pagamento -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0">Métodos de Pagamento</h3>
                        </div>
                        <div class="card-body">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" name="payment_methods[pix]" class="custom-control-input" id="pix" 
                                       {{ isset($checkout->payment_methods['pix']) && $checkout->payment_methods['pix'] ? 'checked' : '' }}>
                                <label class="custom-control-label" for="pix">PIX</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" name="payment_methods[credit_card]" class="custom-control-input" id="credit_card"
                                       {{ isset($checkout->payment_methods['credit_card']) && $checkout->payment_methods['credit_card'] ? 'checked' : '' }}>
                                <label class="custom-control-label" for="credit_card">Cartão de Crédito</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" name="payment_methods[boleto]" class="custom-control-input" id="boleto"
                                       {{ isset($checkout->payment_methods['boleto']) && $checkout->payment_methods['boleto'] ? 'checked' : '' }}>
                                <label class="custom-control-label" for="boleto">Boleto</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" name="payment_methods[bank_transfer]" class="custom-control-input" id="bank_transfer"
                                       {{ isset($checkout->payment_methods['bank_transfer']) && $checkout->payment_methods['bank_transfer'] ? 'checked' : '' }}>
                                <label class="custom-control-label" for="bank_transfer">Transferência Bancária</label>
                            </div>
                        </div>
                    </div>

                    <!-- Configurações Adicionais -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="mb-0">Configurações Adicionais</h3>
                        </div>
                        <div class="card-body">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" name="theme_config[show_security_badges]" class="custom-control-input" id="security_badges"
                                       {{ isset($checkout->theme_config['show_security_badges']) && $checkout->theme_config['show_security_badges'] ? 'checked' : '' }}>
                                <label class="custom-control-label" for="security_badges">Exibir Selos de Segurança</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" name="theme_config[show_testimonials]" class="custom-control-input" id="testimonials"
                                       {{ isset($checkout->theme_config['show_testimonials']) && $checkout->theme_config['show_testimonials'] ? 'checked' : '' }}>
                                <label class="custom-control-label" for="testimonials">Exibir Depoimentos</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" name="theme_config[enable_countdown]" class="custom-control-input" id="countdown"
                                       {{ isset($checkout->theme_config['enable_countdown']) && $checkout->theme_config['enable_countdown'] ? 'checked' : '' }}>
                                <label class="custom-control-label" for="countdown">Ativar Timer de Contagem</label>
                            </div>
                        </div>
                    </div>

                    <!-- Carrinho Abandonado -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="mb-0">Recuperação de Carrinho</h3>
                        </div>
                        <div class="card-body">
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" name="abandoned_cart_config[enabled]" class="custom-control-input" id="abandoned_cart" 
                                       onchange="toggleAbandonedCart()"
                                       {{ isset($checkout->abandoned_cart_config['enabled']) && $checkout->abandoned_cart_config['enabled'] ? 'checked' : '' }}>
                                <label class="custom-control-label" for="abandoned_cart">Ativar Recuperação de Carrinho</label>
                            </div>

                            <div id="abandoned-cart-options" style="{{ isset($checkout->abandoned_cart_config['enabled']) && $checkout->abandoned_cart_config['enabled'] ? '' : 'display: none;' }}">
                                <div class="form-group">
                                    <label class="form-control-label">Tempo para Considerar Abandonado (minutos)</label>
                                    <input type="number" name="abandoned_cart_config[time_minutes]" class="form-control"
                                           value="{{ old('abandoned_cart_config.time_minutes', $checkout->abandoned_cart_config['time_minutes'] ?? 30) }}" min="5" max="1440">
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Desconto de Recuperação (%)</label>
                                    <input type="number" name="abandoned_cart_config[discount_percentage]" class="form-control"
                                           value="{{ old('abandoned_cart_config.discount_percentage', $checkout->abandoned_cart_config['discount_percentage'] ?? 10) }}" min="0" max="100">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ações -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save"></i> Salvar Alterações
                            </button>
                            <button type="button" class="btn btn-secondary btn-block" onclick="saveAsDraft()">
                                <i class="fas fa-file"></i> Salvar como Rascunho
                            </button>
                            <a href="{{ route('user.checkout-builder.index') }}" class="btn btn-light btn-block">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('js')
<script>
function toggleAbandonedCart() {
    const checkbox = document.getElementById('abandoned_cart');
    const options = document.getElementById('abandoned-cart-options');
    options.style.display = checkbox.checked ? 'block' : 'none';
}

function saveAsDraft() {
    const form = document.getElementById('checkout-form');
    const statusSelect = form.querySelector('select[name="status"]');
    statusSelect.value = 'draft';
    form.submit();
}
</script>
@endpush

@endsection