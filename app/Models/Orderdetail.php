<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orderdetail extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ord_id','customer_id','customer_num','customer_add','product_id','quantity','mrp','tax_id','total_amount','stock'];

    protected $dates = ['deleted_at'];
}
