<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'balance',
        'credit_limit',
        'billing_cycle_start',
        'billing_cycle_end',
        'due_date'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
