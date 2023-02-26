<?php

namespace App\Http\Traits;

use App\Models\Customer;
use App\Models\Customertransaction;



trait CustomerTrait {


    public function id_generator() 
    {
        $prefix = "C";

        $data = Customer::orderBy('id','desc')->first();

        if(empty($data)) {
            $last_code_suffix = 0;
        }
        else {
            $z = explode('-', $data->cust_code);
            $last_code_suffix =  array_pop($z);
        }

        $x = sprintf("%05d", $last_code_suffix+1);
        $new_code = $prefix.'-'.$x;
       
        return $new_code;
    }

    public function cuspur_id_generator() 
    {
        $prefix = "CT";

        $data = Customertransaction::orderBy('id','desc')->first();

        if(empty($data)) {
            $last_code_suffix = 0;
        }
        else {
            $z = explode('-', $data->transaction_code);
            $last_code_suffix =  array_pop($z);
        }

        $x = sprintf("%05d", $last_code_suffix+1);
        $new_code = $prefix.'-'.$x;
       
        return $new_code;
    }

    public function empid_generator() 
    {
        $prefix = "EMP";

        $data = Employee::orderBy('id','desc')->first();

        if(empty($data)) {
            $last_code_suffix = 0;
        }
        else {
            $z = explode('-', $data->emp_code);
            $last_code_suffix =  array_pop($z);
        }

        $x = sprintf("%05d", $last_code_suffix+1);
        $new_code = $prefix.'-'.$x;
       
        return $new_code;
    }

}

