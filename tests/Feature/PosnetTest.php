<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Client;
use App\Models\CreditCard;

class PosnetTest extends TestCase
{
    use RefreshDatabase;

    public function testPaymentSuccess()
    {
        $client = Client::create([
            'dni' => '12345678',
            'first_name' => 'John',
            'last_name' => 'Doe'
        ]);

        $card = CreditCard::create([
            'client_id' => $client->id,
            'card_type' => 'Visa',
            'bank_name' => 'BankX',
            'card_number' => '12345678',
            'limit' => 1000.00,
            'available_limit' => 1000.00,
        ]);

        $response = $this->postJson('/api/process-payment', [
            'card_number' => '12345678',
            'amount' => 100,
            'installments' => 1
        ]);
        // echo $response->getContent();
        $response->assertStatus(200);
    }
}
