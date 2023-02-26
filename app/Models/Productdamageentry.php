<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Productdamageentry extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['damage_product','damage_rate','damage_quantity','damage_total','note','damage_date'];

    protected $dates = ['deleted_at'];
}
