<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CreditCard extends Model
{
    use HasFactory;

    public $fillable = [
        'client_id',
        'card_type',
        'bank_name',
        'card_number',
        'limit',
        'available_limit',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
