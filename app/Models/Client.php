<?php

namespace App\Models;

use App\Models\CreditCard;
use Database\Factories\ClientFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    /** @use HasFactory<ClientFactory> */
    use HasFactory;

    public $fillable = [
        'dni',
        'first_name',
        'last_name',
    ];

    /**
     * @return HasMany<CreditCard>
     */
    public function creditCards(): HasMany
    {
        return $this->hasMany(CreditCard::class);
    }
}
