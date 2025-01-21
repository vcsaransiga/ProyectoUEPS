<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_date',
        'total',
        'payment_method',
        'customer_id',
        'employee_id',
        'comments',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class, 'sale_id', 'id');
    }
}
