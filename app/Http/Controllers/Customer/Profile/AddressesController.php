<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\SalesProcess\UpdateAddressRequest;
use App\Models\Market\Address;
use App\Models\Province;
use Illuminate\Http\Request;

class AddressesController extends Controller
{
    public function index()
    {
        $provinces = Province::all();
        return view('customer.profile.my-addresses' , compact('provinces'));
    }


}
