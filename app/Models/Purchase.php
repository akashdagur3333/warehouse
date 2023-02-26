<?php

namespace App\Models;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;
    protected $fillable = ['invoice_no','purchase_by','purchase_date','supplier_name','supplier_mobile','supplier_address','product','purchase_rate','quantity','total','vat_tk','discount_tk','transport_cost','totalam','paid','due'];

    protected $dates = ['deleted_at'];
   
}
