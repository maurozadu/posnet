<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\CreditCardFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CreditCard extends Model
{
    /** @use HasFactory<CreditCardFactory> */
    use HasFactory;

    public $fillable = [
        'client_id',
        'card_type',
        'bank_name',
        'card_number',
        'limit',
        'available_limit',
    ];

    /**
     * @return BelongsTo<Client,CreditCard>
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
