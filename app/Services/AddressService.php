<?php

namespace App\Services;

use App\DTOs\AddressDTO;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddressService
{
    public function getAddresses(string $values): array
    {
        $parts = explode(',', $values);
        $reversedParts = array_reverse($parts);
        $results = [];
        $error = "";

        foreach($reversedParts as $cep) {
            $url = "https://viacep.com.br/ws/{$cep}/json/";

            try {
                $response = Http::withoutVerifying()->get($url);

                if ($response->successful()) {
                    $data = $response->json();
                    $results[] = new AddressDTO($data);
                } else {
                    $error = 'Failed to fetch data for CEP: ' . $cep;
                }
            } catch (\Exception $e) {
                $error = 'Exception occurred: ' . $e->getMessage();
            }
        };

        if (!empty($error)) {
            throw new HttpResponseException(
                response()->json(['error' => $error], 422)
            );
        }

        return $results;
    }
}