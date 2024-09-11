<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\CreditCardFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
