<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'type',
        'amount',
        'category',
        'description',
        'related_account_id',
        'transaction_mode',
        'upi_app',
        'transaction_fee',
        'loan_type',
        'related_person',
        'transaction_date'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
