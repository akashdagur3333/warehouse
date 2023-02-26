<?php

namespace App\Models;

use App\Models\Rawmaterial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Rawmaterial extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['rawmaterial_code','product_name', 'category', 'freshness', 'material_unit','stock','price', 're_order', 'date', 'status'];

    protected $dates = ['deleted_at'];

}
