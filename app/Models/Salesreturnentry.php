<?php

namespace App\Models;

use App\Models\Salesreturnentry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salesreturnentry extends Model
{ 
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;
    protected $fillable = ['sales_invoice','return_date','customer_name','customer_mobile','customer_address','product','return_rate','quantity','total'];

    protected $dates = ['deleted_at'];
}
