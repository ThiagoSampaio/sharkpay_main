@extends('userlayout')

@section('content')
<div class="container-fluid">
    <div class="header pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6">
                        <h1 class="display-4 text-white">Criar Novo Checkout</h1>
                        <p class="text-light">Configure seu checkout otimizado para conversões</p>
                    </div>
                    <div class="col-lg-6 text-right">
                        <a href="{{ route('user.checkout-builder.index') }}" class="btn btn-neutral">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <form action="{{ route('user.checkout-builder.store') }}" method="POST" id="checkout-form">
            @csrf
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
                                       placeholder="Ex: Checkout Black Friday" value="{{ old('name') }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">Descrição</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                          rows="3" placeholder="Descreva o propósito deste checkout">{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>
                            <h4 class="mb-3">Configuração do Funil</h4>

                            <div class="form-group">
                                <label class="form-control-label">Produto Principal *</label>
                                <select name="funnel_config[main_product]" class="form-control" required>
                                    <option value="">Selecione o produto principal</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('funnel_config.main_product') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} - R$ {{ number_format($product->amount, 2, ',', '.') }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">URL de Redirecionamento (Sucesso)</label>
                                <input type="url" name="funnel_config[success_url]" class="form-control"
                                       placeholder="https://seusite.com/obrigado" value="{{ old('funnel_config.success_url') }}">
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">URL de Redirecionamento (Cancelamento)</label>
                                <input type="url" name="funnel_config[cancel_url]" class="form-control"
                                       placeholder="https://seusite.com/cancelado" value="{{ old('funnel_config.cancel_url') }}">
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
                                    <option value="{{ $product->id }}">
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
                                    <option value="{{ $product->id }}">
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
                                               value="{{ old('theme_config.primary_color', '#007bff') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Cor Secundária</label>
                                        <input type="color" name="theme_config[secondary_color]" class="form-control"
                                               value="{{ old('theme_config.secondary_color', '#6c757d') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Layout</label>
                                        <select name="theme_config[layout]" class="form-control">
                                            <option value="single-column">Coluna Única</option>
                                            <option value="two-column">Duas Colunas</option>
                                            <option value="minimal">Minimalista</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Estilo dos Botões</label>
                                        <select name="theme_config[button_style]" class="form-control">
                                            <option value="rounded">Arredondado</option>
                                            <option value="square">Quadrado</option>
                                            <option value="pill">Pílula</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">URL do Logo (opcional)</label>
                                <input type="url" name="logo_url" class="form-control"
                                       placeholder="https://seusite.com/logo.png" value="{{ old('logo_url') }}">
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">CSS Personalizado (opcional)</label>
                                <textarea name="custom_css" class="form-control" rows="5"
                                          placeholder="/* Seu CSS personalizado aqui */">{{ old('custom_css') }}</textarea>
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
                                <input type="checkbox" name="payment_methods[pix]" class="custom-control-input" id="pix" checked>
                                <label class="custom-control-label" for="pix">PIX</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" name="payment_methods[credit_card]" class="custom-control-input" id="credit_card" checked>
                                <label class="custom-control-label" for="credit_card">Cartão de Crédito</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" name="payment_methods[boleto]" class="custom-control-input" id="boleto" checked>
                                <label class="custom-control-label" for="boleto">Boleto</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" name="payment_methods[bank_transfer]" class="custom-control-input" id="bank_transfer">
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
                                <input type="checkbox" name="theme_config[show_security_badges]" class="custom-control-input" id="security_badges" checked>
                                <label class="custom-control-label" for="security_badges">Exibir Selos de Segurança</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" name="theme_config[show_testimonials]" class="custom-control-input" id="testimonials" checked>
                                <label class="custom-control-label" for="testimonials">Exibir Depoimentos</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" name="theme_config[enable_countdown]" class="custom-control-input" id="countdown">
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
                                <input type="checkbox" name="abandoned_cart_config[enabled]" class="custom-control-input" id="abandoned_cart" onchange="toggleAbandonedCart()">
                                <label class="custom-control-label" for="abandoned_cart">Ativar Recuperação de Carrinho</label>
                            </div>

                            <div id="abandoned-cart-options" style="display: none;">
                                <div class="form-group">
                                    <label class="form-control-label">Tempo para Considerar Abandonado (minutos)</label>
                                    <input type="number" name="abandoned_cart_config[time_minutes]" class="form-control"
                                           value="{{ old('abandoned_cart_config.time_minutes', 30) }}" min="5" max="1440">
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Desconto de Recuperação (%)</label>
                                    <input type="number" name="abandoned_cart_config[discount_percentage]" class="form-control"
                                           value="{{ old('abandoned_cart_config.discount_percentage', 10) }}" min="0" max="100">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ações -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save"></i> Criar Checkout
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
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'status';
    input.value = 'draft';
    form.appendChild(input);
    form.submit();
}

// Preview em tempo real das cores
document.querySelector('input[name="theme_config[primary_color]"]').addEventListener('change', function(e) {
    // Implementar preview
    console.log('Cor primária:', e.target.value);
});

document.querySelector('input[name="theme_config[secondary_color]"]').addEventListener('change', function(e) {
    // Implementar preview
    console.log('Cor secundária:', e.target.value);
});
</script>
@endpush

@endsection