<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producttransferentry extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;
    protected $fillable = ['transfer_by','product','transfer_date','stock','rate','quantity','total','transfer_note'];

    protected $dates = ['deleted_at'];
   
}
