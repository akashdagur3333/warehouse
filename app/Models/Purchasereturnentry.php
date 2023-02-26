<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchasereturnentry extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;
    protected $fillable = ['purchase_invoice','return_date','supplier_name','supplier_mobile','supplier_address','product','return_rate','quantity','total'];

    protected $dates = ['deleted_at'];
}
