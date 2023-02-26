<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['cust_code', 'cust_name', 'institution', 'address', 'phone',  'country', 'state','choose_employee', 'previous_due', 'credit_limit', 'cust_type'];

    protected $dates = ['deleted_at'];
    public function statein()
    {
        return $this->belongsTo('App\Models\State', 'state');
    }
}
