<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;


class Customertransaction extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['invoice_no','transaction_code', 'customer', 'cust_institution', 'payment_method', 'current_due', 'entry_date', 'bankacc_name', 'note', 'amount'];

    protected $dates = ['deleted_at'];
    
}
