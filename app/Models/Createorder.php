<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Createorder extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['customer_id'];

    protected $dates = ['deleted_at'];
}
