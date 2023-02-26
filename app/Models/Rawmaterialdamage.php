<?php

namespace App\Models;

use App\Models\Rawmaterialdamage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rawmaterialdamage extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;
    protected $fillable = ['damage_code','damage_date','material_name','damage_rate','damage_quantity','damage_total','note'];

    protected $dates = ['deleted_at'];
}
