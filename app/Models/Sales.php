<?php

namespace App\Models;

use App\Models\Sales;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sales extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;
    protected $fillable = ['invoice_no','sales_by','sales_date','customer_name','customer_mobile','customer_address','product','sales_rate','quantity','total','vat_tk','discount_tk','transport_cost','totalam','paid','due'];

    protected $dates = ['deleted_at'];
}
