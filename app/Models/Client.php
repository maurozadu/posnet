<?php

namespace App\Models;

use App\Models\CreditCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    public $fillable = [
        'dni',
        'first_name',
        'last_name',
    ];

    public function creditCards()
    {
        return $this->hasMany(CreditCard::class);
    }
}
