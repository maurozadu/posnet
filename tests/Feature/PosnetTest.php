<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Client;
use App\Models\CreditCard;
use Database\Factories\CreditCardFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PosnetTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public $ticketJsonFormat = [
        'ticket' => [
            'client_name',
            'total_amount',
            'installment_amount',
        ],
    ];

    public function testPaymentSuccess(): void
    {
        $card = CreditCardFactory::new(['available_limit' => 2000])->create();
        $response = $this->postJson('/api/process-payment', [
            'card_number' => $card->card_number,
            'amount' => 1000,
            'installments' => 1,
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure($this->ticketJsonFormat);
    }

    public function testPaymentSuccessWithInstallments()
    {
        $card = CreditCardFactory::new()->create();
        $installments = 3;
        $response = $this->postJson('/api/process-payment', [
            'card_number' => $card->card_number,
            'amount' => 1000,
            'installments' => $installments,
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure($this->ticketJsonFormat);
        $ticket = $response->json('ticket');
        $expectedTotalAmount = 1000 * 1.06;
        $expectedInstallmentAmount = $expectedTotalAmount / $installments;
        $this->assertEquals($expectedTotalAmount, $ticket['total_amount']);
        $this->assertEquals($expectedInstallmentAmount, $ticket['installment_amount']);
    }

    public function testPaymentFailedInsufficientFunds()
    {
        $card = CreditCardFactory::new(['available_limit' => 900])->create();
        $response = $this->postJson('/api/process-payment', [
            'card_number' => $card->card_number,
            'amount' => 1000,
            'installments' => 1,
        ]);
        $response->assertStatus(400);
        $response->assertJson(['error' => 'Insufficient available limit']);
    }
}
