<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'total_price',
        'no_reff',
        'payment_status',
        'payment_method_id',
        'transaction_date',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
