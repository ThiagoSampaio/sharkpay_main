@extends('paymentlayout')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.min.css" />
<style>
	.nav-pills .nav-link.active, .nav-pills .show > .nav-link {
		color: #fff;
		background-color: rgb(136 3 255 / 1);
	}
</style>

<div class="main-content">
    <div class="header py-7 py-lg-6 pt-lg-1">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="row mb-3 text-left">
                        <div class="col-md-2">
                            @foreach($image as $vl)
                                <img src="{{url('/')}}/asset/profile/{{$vl->image}}" style="width: 75%;">
                            @endforeach
                        </div>
                        <div class="col-md-10">
                            <h1 class="text-dark font-weight-bolder">{{ $product->name }}</h1>
                            <p>{{ $product->description }}</p>
                            <h2>{{ $currency->symbol }} {{ number_format($product->amount, 2, ",", ".") }}</h2>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                        	<form action="{{ route('pay.product') }}" method="post" id="payment-form">
	                            @csrf
	                            {{-- Hidden --}}
	                            <input type="hidden" name="ref_id" value="{{ $ref }}">
	                            <input type="hidden" name="product_id" value="{{ $product->id }}">
	                            <input type="hidden" name="amount" value="{{ $product->amount }}">
	                            <input type="hidden" name="type" id="payment_method" value="pix">

	                            @if (!Auth::guard('user')->check())
	                            <div class="row">
	                                <div class="col-md-6">
	                                    <input type="text" name="first_name" class="form-control mb-3" placeholder="{{ $lang['product_first_name'] }}" required>
	                                </div>
	                                <div class="col-md-6">
	                                    <input type="text" name="last_name" class="form-control mb-3" placeholder="{{ $lang['product_last_name'] }}" required>
	                                </div>
	                                <div class="col-md-6">
	                                    <input type="number" name="document" class="form-control mb-3" placeholder="{{ $lang['product_your_document'] }}" required>
	                                </div>
	                                <div class="col-md-6 d-flex">
	                                    <select name="country_code" class="form-control mr-2" required>
	                                        <option value="+55">🇧🇷 +55</option>
	                                        <option value="+1">🇺🇸 +1</option>
	                                        <option value="+44">🇬🇧 +44</option>
	                                        <option value="+351">🇵🇹 +351</option>
	                                    </select>
	                                    <input type="tel" name="phone" class="form-control" placeholder="{{ $lang['product_mobile_number'] }}" required>
	                                </div>
	                                <div class="col-md-12 mt-3">
	                                    <input type="email" name="email" class="form-control" placeholder="{{ $lang['product_your_email_address'] }}" required>
	                                </div>
	                            </div>
	                            @endif

	                            {{-- Tabs --}}
	                            <ul class="nav nav-pills nav-justified mt-4 mb-3" id="paymentTabs" role="tablist">
	                                <li class="nav-item">
	                                    <a class="nav-link active" id="pix-tab" data-toggle="tab" href="#pix" role="tab" aria-selected="true">
	                                        <i class="fas fa-qrcode mr-1"></i> Pix
	                                    </a>
	                                </li>
	                                <li class="nav-item">
	                                    <a class="nav-link" id="card-tab" data-toggle="tab" href="#card" role="tab" aria-selected="false">
	                                        <i class="fas fa-credit-card mr-1"></i> Cartão
	                                    </a>
	                                </li>
	                                <li class="nav-item">
	                                    <a class="nav-link" id="boleto-tab" data-toggle="tab" href="#boleto" role="tab" aria-selected="false">
	                                        <i class="fas fa-barcode mr-1"></i> Boleto
	                                    </a>
	                                </li>
	                            </ul>

	                            <div class="tab-content">
	                                {{-- Pix --}}
	                                <div class="tab-pane fade show active" id="pix" role="tabpanel" style="padding: 20px;
    background-color: #8803ff1a;
    border: 1px solid #8803ff;
    border-radius: 10px;
}">
	                                    <h5>Informações sobre o pagamento via pix:</h5>
	                                    <ul class="text-dark">
	                                        <li>Valor à vísta: <strong>{{ $currency->symbol }} {{ number_format($product->amount, 2, ",", ".") }}</strong> à vista</li>
	                                        <li>Liberação imediata</li>
	                                        <li>É simples, só usar o aplicativo de seu banco para pagar PIX.</li>
	                                        <li>Super seguro. O pagamento PIX foi desenvolvido pelo Banco Central para facilitar pagamentos.</li>
	                                    </ul>

										<!-- Exibido após gerar o Pix -->
										<div class="row row-pix-with-pix d-none mt-4">
										    <div class="col-12 text-center">
										        <h4>Total: <span id="pix-total">--</span></h4>
										        <img id="pix-img-qrcode" src="" alt="QR Code Pix" class="img-fluid my-3" style="max-width: 200px;">
										    </div>

										    <div class="col-12">
										        <div class="form-group">
										            <label for="pix-copypaste">Copia e Cola Pix</label>
										            <div class="input-group">
										                <input type="text" id="pix-copypaste" class="form-control" readonly>
										                <div class="input-group-append">
										                    <button class="btn btn-outline-secondary" type="button" onclick="copyPixCode()">Copiar</button>
										                </div>
										            </div>
										        </div>
										    </div>
										</div>



	                                </div>



	                                {{-- Cartão --}}
	                                <div class="tab-pane fade" id="card" role="tabpanel" style="padding: 20px;
    background-color: #8803ff1a;
    border: 1px solid #8803ff;
    border-radius: 10px;
}">
	                                    <h5>Pagamento via Cartão</h5>
	                                    <input type="text" name="card_name" class="form-control mb-2" placeholder="Nome no cartão">
	                                    <input type="text" name="card_number" class="form-control mb-2" placeholder="Número do cartão">
	                                    <div class="row">
	                                        <div class="col-md-6">
	                                            <input type="text" name="card_expiry" class="form-control mb-2" placeholder="Validade (MM/AA)">
	                                        </div>
	                                        <div class="col-md-6">
	                                            <input type="text" name="card_cvv" class="form-control mb-2" placeholder="CVV">
	                                        </div>
	                                    </div>
	                                </div>

	                                {{-- Boleto --}}
	                                <div class="tab-pane fade" id="boleto" role="tabpanel" style="padding: 20px;
    background-color: #8803ff1a;
    border: 1px solid #8803ff;
    border-radius: 10px;
}">
	                                    <h5>Pagamento via Boleto</h5>
	                                    <p>Clique em "Pagar agora" para gerar o boleto.</p>
	                                </div>
	                            </div>

	                            {{-- Botão Final --}}
	                            <div id="payment-buttons" class="mt-4">
								    <button type="button" id="btn-pay-order-pix" class="btn btn-success btn-lg btn-block" onclick="payOrderWithPix()">Pagar agora</button>
								    <button type="submit" id="btn-pay-card" class="btn btn-primary btn-lg btn-block d-none">Pagar com Cartão</button>
								    <button type="submit" id="btn-pay-boleto" class="btn btn-secondary btn-lg btn-block d-none">Gerar Boleto</button>
								</div>

	                            {{-- Rodapé --}}
	                            <div class="text-center mt-4">
	                                <img src="{{ url('/') }}/asset/{{ $logo->image_link }}" class="img-fluid" style="max-height: 80px;">
	                                <p>
	                            		<small>Ao clicar em 'Pagar agora', eu declaro que 
	                            		<br>(i) estou ciente que a {{env('APP_NAME')}} está processando essa compra em nome de {produtor} e que não possui responsabilidade pelo conteúdo, oferta, e nem faz controle prévio do infoproduto; 
	                            		<br>(ii) que li e concordo com os Termos de Compra, Termos de Uso, e Política de Privacidade.</small></p>
									<p><small>Denunciar esse produto.</small></p>
									<p><small>*Parcelamento com acréscimo.</small></p>
									<p><small>Este site está protegido pelo Google reCAPTCHA.</small></p>
									<p><small>Política de Privacidade e Termos de Serviço.</small></p>
	                            </div>
	                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {
    $('#paymentTabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    	console.log('aqui')
        const target = $(e.target).attr("href"); // ex: #pix, #card, #boleto

        // Esconde todos os botões
        $('#btn-pay-order-pix, #btn-pay-card, #btn-pay-boleto').addClass('d-none');

        // Mostra o botão correspondente
        if (target === "#pix") {
            $('#btn-pay-order-pix').removeClass('d-none');
        } else if (target === "#card") {
            $('#btn-pay-card').removeClass('d-none');
        } else if (target === "#boleto") {
            $('#btn-pay-boleto').removeClass('d-none');
        }
    });

    // Gatilho inicial (ativa botão certo no carregamento)
    $('#paymentTabs a.active').trigger('shown.bs.tab');
});

document.getElementById('payment-form').addEventListener('submit', function(e) {
    // Remove 'required' de campos invisíveis
    document.querySelectorAll('#payment-form input[required]').forEach(function(input) {
        if (input.offsetParent === null) {
            input.removeAttribute('required');
        }
    });

    // Define o método de pagamento de acordo com a aba ativa
    const activeTab = document.querySelector('.nav-link.active').getAttribute('id');
    if (activeTab === 'pix-tab') {
        document.getElementById('payment_method').value = 'pix';
    } else if (activeTab === 'card-tab') {
        document.getElementById('payment_method').value = 'card';
    } else if (activeTab === 'boleto-tab') {
        document.getElementById('payment_method').value = 'boleto';
    }
});

function payOrderWithPix() {
    let formdata = $('#payment-form').serialize();

    // $('#payment-form input, #payment-form select')
    // .not('[type=hidden]')
    // .not('#pix-copypaste')
    // .prop('disabled', true);


    $.post("{{ route('product.proccess.payment') }}", formdata, function (json) {
        if (json.success) {
            // Mostrar QR Code e informações
            $(".row-pix-with-pix").removeClass('d-none');
            $("#pix-total").text("R$ " + json.total);
            $("#pix-img-qrcode").attr("src", json.qrcode);
            $("#pix-copypaste").val(json.copy);

            // Ocultar inputs do formulário
            if(json.success != 'false') {
	            $('#payment-form input, #payment-form select')
	            .not('[type=hidden]')
	    		.not('#pix-copypaste')
	    		.prop('disabled', true);
            	
            }

            // Esconder botões de envio (opcional)
            $('#btn-pay-order-pix, #btn-pay-card, #btn-pay-boleto').hide();
        } else {
            toastr.error(json.message || "Erro no pagamento via Pix");
        }
    }, 'json').fail(function () {
        toastr.error("Erro ao processar pagamento.");
    }).always(function () {
        $("#btn-pay-order-pix").prop("disabled", false);
    });
}

// Copiar código Pix
function copyPixCode() {
    const input = document.getElementById("pix-copypaste");
    input.select();
    input.setSelectionRange(0, 99999); // mobile
    document.execCommand("copy");
    toastr.success("Código Pix copiado!");
}


</script>
@endpush
