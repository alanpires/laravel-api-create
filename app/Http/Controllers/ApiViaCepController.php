<?php

namespace App\Http\Controllers;

use App\Services\AddressService;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiViaCepController extends Controller
{
    protected $adressService;

    public function __construct(AddressService $addressService) {
        $this->addressService = $addressService;
    }

    public function getAddresses($values) 
    {
        try {
            $addressList = $this->addressService->getAddresses($values);
            return response()->json($addressList);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unexpected error occurred'], 500);
        }
    }
}
