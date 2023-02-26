<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quotationorder extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ord_id','customer_id','customer_num','customer_add','invoice_num','sales_by','sales_date','sub_total','sub_quantity','transport_cost','vat_per','vat_tk','discount_per','discount_tk','total'];

    protected $dates = ['deleted_at'];
}
