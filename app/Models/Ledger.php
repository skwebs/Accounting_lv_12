<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    // use HasFactory;

    // protected $fillable = [
    //     'user_id',
    //     'name',
    //     'type',
    //     'balance',
    //     'credit_limit',
    //     'billing_cycle_start',
    //     'billing_cycle_end',
    //     'due_date'
    // ];

    // public function transactions()
    // {
    //     return $this->hasMany(Transaction::class);
    // }

    use HasFactory;

    protected $fillable = [
        'user_id',
        'related_person',
        'loan_type',
        'total_amount',
        'paid_amount',
        'remaining_amount',
        'status'
    ];
}
