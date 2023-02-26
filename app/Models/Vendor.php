<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['company', 'phone', 'email', 'address', 'state', 'country', 'pincode', 'gstin', 'cin','previous_due'];

    protected $dates = ['deleted_at'];

    public function statein()
    {
        return $this->belongsTo('App\Models\State', 'state');
    }
}
