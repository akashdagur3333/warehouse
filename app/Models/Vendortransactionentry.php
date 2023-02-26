<?php

namespace App\Models;

use App\Models\Vendortransactionentry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DataTables;
class Vendortransactionentry extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;
    protected $fillable = ['purchase_date','supplier_name','transaction_id','transaction_type','transaction_method','note','amount'];

    protected $dates = ['deleted_at'];
   
}
