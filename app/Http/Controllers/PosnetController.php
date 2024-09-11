<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\CreditCard;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PosnetController extends Controller
{
    public function registerCard(Request $request): JsonResponse
    {
        $request->validate([
            'dni' => 'required|string|max:10',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'card_type' => 'required|in:Visa,AMEX',
            'bank_name' => 'required|string',
            'card_number' => 'required|digits:8|unique:credit_cards',
            'limit' => 'required|numeric|min:1',
        ]);

        $client = Client::firstOrCreate(
            ['dni' => $request->dni],
            ['first_name' => $request->first_name, 'last_name' => $request->last_name]
        );

        $card = CreditCard::create([
            'client_id' => $client->id,
            'card_type' => $request->card_type,
            'bank_name' => $request->bank_name,
            'card_number' => $request->card_number,
            'limit' => $request->limit,
            'available_limit' => $request->limit,
        ]);

        return response()->json(['message' => 'Card registered successfully!'], 201);
    }

    public function doPayment(Request $request): JsonResponse
    {
        $request->validate([
            'card_number' => 'required|digits:8|exists:credit_cards,card_number',
            'amount' => 'required|numeric|min:1',
            'installments' => 'required|integer|min:1|max:6',
        ]);

        $card = CreditCard::where('card_number', $request->card_number)->first();

        if (!$card) {
            return response()->json(['error' => 'Card not found'], 404);
        }

        $totalAmount = $request->amount;
        if ($request->installments > 1) {
            $totalAmount += $totalAmount * (0.03 * ($request->installments - 1));
        }

        if ($card->available_limit < $totalAmount) {
            return response()->json(['error' => 'Insufficient available limit'], 400);
        }

        // Deduct from available limit
        $card->available_limit -= $totalAmount;
        $card->save();

        if (empty($card->client)) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        // Generate ticket
        $ticket = [
            'client_name' => $card->client->first_name . ' ' . $card->client->last_name,
            'total_amount' => $totalAmount,
            'installment_amount' => $totalAmount / $request->installments,
        ];

        return response()->json(['ticket' => $ticket], 200);
    }
}
