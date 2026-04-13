<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\SupportAttachment;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupportTicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ticket_belongs_to_user()
    {
        $user = User::factory()->create();
        $ticket = SupportTicket::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $ticket->user);
        $this->assertEquals($user->id, $ticket->user->id);
    }

    /** @test */
    public function ticket_belongs_to_product()
    {
        $product = Product::factory()->create();
        $ticket = SupportTicket::factory()->create(['product_id' => $product->id]);

        $this->assertInstanceOf(Product::class, $ticket->product);
        $this->assertEquals($product->id, $ticket->product->id);
    }

    /** @test */
    public function ticket_has_many_messages()
    {
        $ticket = SupportTicket::factory()->create();
        $message = SupportMessage::factory()->create(['ticket_id' => $ticket->id]);

        $this->assertInstanceOf(SupportMessage::class, $ticket->messages->first());
    }

    /** @test */
    public function ticket_has_many_attachments()
    {
        $ticket = SupportTicket::factory()->create();
        $attachment = SupportAttachment::factory()->create(['ticket_id' => $ticket->id]);

        $this->assertInstanceOf(SupportAttachment::class, $ticket->attachments->first());
    }

    /** @test */
    public function is_open_returns_true_for_open_ticket()
    {
        $ticket = SupportTicket::factory()->create(['status' => 'open']);

        $this->assertTrue($ticket->isOpen());
    }

    /** @test */
    public function is_closed_returns_true_for_closed_ticket()
    {
        $ticket = SupportTicket::factory()->create(['status' => 'closed']);

        $this->assertTrue($ticket->isClosed());
    }

    /** @test */
    public function is_in_progress_returns_true_for_in_progress_ticket()
    {
        $ticket = SupportTicket::factory()->create(['status' => 'in_progress']);

        $this->assertTrue($ticket->isInProgress());
    }
}
