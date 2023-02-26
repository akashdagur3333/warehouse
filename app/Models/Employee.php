<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;


class Employee extends Model
{
    use HasFactory, AuditableWithDeletesTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'father_name', 'mother_name', 'gender', 'dob', 'blood_group', 'marital_status', 'phone', 'alt_phone', 'email', 'aadhar', 'religion', 'nationality', 'address', 'city', 'district', 'state', 'zip', 'p_address', 'p_city', 'p_district', 'p_state', 'p_zip', 'status'];

    protected $dates = ['deleted_at'];

}
