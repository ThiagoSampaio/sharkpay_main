<?php

namespace App\Mail;

use App\Models\Cart;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AbandonedCartRecovery extends Mailable
{
    use Queueable, SerializesModels;

    public $cart;
    public $recoveryUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
        $this->recoveryUrl = route('cart.recover', ['id' => $cart->uniqueid]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $attemptNumber = $this->cart->recovery_attempts + 1;

        $subject = $attemptNumber === 1
            ? 'Você esqueceu algo no carrinho!'
            : 'Seu carrinho ainda está te esperando!';

        // Add discount for second and third attempts
        $discountPercentage = $attemptNumber === 2 ? 10 : ($attemptNumber === 3 ? 15 : 0);

        return $this->subject($subject)
            ->view('emails.abandoned-cart')
            ->with([
                'cartItems' => $this->getCartItems(),
                'attemptNumber' => $attemptNumber,
                'discountPercentage' => $discountPercentage,
                'total' => $this->cart->total,
            ]);
    }

    /**
     * Parse cart items from product field
     */
    protected function getCartItems()
    {
        // Assuming product field stores serialized or JSON data
        // Adjust based on your actual cart structure
        return [
            [
                'title' => $this->cart->title,
                'quantity' => $this->cart->quantity,
                'price' => $this->cart->cost,
                'total' => $this->cart->total,
            ]
        ];
    }
}
