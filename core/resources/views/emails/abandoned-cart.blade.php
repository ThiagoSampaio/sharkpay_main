<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho Abandonado</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px 20px;
        }
        .cart-item {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .item-title {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        .item-details {
            color: #666;
            font-size: 14px;
        }
        .total {
            background-color: #f8f9fa;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: right;
        }
        .total-label {
            font-size: 14px;
            color: #666;
        }
        .total-amount {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-top: 5px;
        }
        .discount-badge {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            display: inline-block;
            margin: 15px 0;
            font-weight: bold;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 15px 40px;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .cta-button:hover {
            opacity: 0.9;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        .urgency {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>
                @if($attemptNumber === 1)
                    Você esqueceu algo! 🛒
                @elseif($attemptNumber === 2)
                    Ainda está pensando? 🤔
                @else
                    Última chance! ⏰
                @endif
            </h1>
        </div>

        <div class="content">
            <p>Olá{{ $cart->customer_name ? ', ' . $cart->customer_name : '' }}!</p>

            @if($attemptNumber === 1)
                <p>Notamos que você deixou alguns itens no carrinho. Não se preocupe, guardamos tudo para você!</p>
            @elseif($attemptNumber === 2)
                <p>Seus itens ainda estão no carrinho te esperando. Para facilitar sua decisão, temos uma surpresa especial! 🎁</p>
            @else
                <p>Esta é sua última chance! Seus itens no carrinho estão quase esgotando e não queremos que você perca essa oportunidade.</p>
            @endif

            @if($discountPercentage > 0)
                <div class="discount-badge">
                    🎉 GANHE {{ $discountPercentage }}% DE DESCONTO!
                </div>
                <p>Use o código <strong>VOLTA{{ $discountPercentage }}</strong> no checkout para aproveitar!</p>
            @endif

            <div style="margin: 30px 0;">
                <h3 style="color: #333; margin-bottom: 15px;">Seus Itens:</h3>
                @foreach($cartItems as $item)
                <div class="cart-item">
                    <div class="item-title">{{ $item['title'] }}</div>
                    <div class="item-details">
                        Quantidade: {{ $item['quantity'] }} |
                        Preço: R$ {{ number_format($item['price'], 2, ',', '.') }}
                    </div>
                </div>
                @endforeach
            </div>

            <div class="total">
                <div class="total-label">Total:</div>
                <div class="total-amount">R$ {{ number_format($total, 2, ',', '.') }}</div>
                @if($discountPercentage > 0)
                    <div style="color: #28a745; font-weight: bold; margin-top: 5px;">
                        Você economiza: R$ {{ number_format($total * $discountPercentage / 100, 2, ',', '.') }}
                    </div>
                @endif
            </div>

            @if($attemptNumber >= 2)
            <div class="urgency">
                <strong>⚠️ Atenção:</strong> Estoque limitado! Seus itens podem não estar disponíveis por muito tempo.
            </div>
            @endif

            <div style="text-align: center;">
                <a href="{{ $recoveryUrl }}" class="cta-button">
                    @if($attemptNumber === 1)
                        Finalizar Minha Compra
                    @elseif($attemptNumber === 2)
                        Resgatar Meu Desconto
                    @else
                        Garantir Agora!
                    @endif
                </a>
            </div>

            <p style="margin-top: 30px; color: #666; font-size: 14px;">
                Dúvidas? Nossa equipe está pronta para ajudar! Responda este email ou entre em contato conosco.
            </p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} SharkPay. Todos os direitos reservados.</p>
            <p>Você recebeu este email porque deixou itens no carrinho em nossa loja.</p>
            <p>
                <a href="#" style="color: #667eea; text-decoration: none;">Política de Privacidade</a> |
                <a href="#" style="color: #667eea; text-decoration: none;">Cancelar Inscrição</a>
            </p>
        </div>
    </div>
</body>
</html>
