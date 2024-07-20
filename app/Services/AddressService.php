<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddressService
{
    public function getAddresses(string $values): array
    {
        $parts = explode(',', $values);
        $reversedParts = array_reverse($parts);
        $results = [];
        $errors = [];

        foreach($reversedParts as $cep) {
            $url = "https://viacep.com.br/ws/{$cep}/json/";

            try {
                $response = Http::withoutVerifying()->get($url);

                if ($response->successful()) {
                    array_push($results, $response->json());
                } else {
                    $errors[$cep] = 'Failed to fetch data for CEP: ' . $cep;
                }
            } catch (\Exception $e) {
                $errors[$cep] = 'Exception occurred: ' . $e->getMessage();
            }
        };

        if (!empty($errors)) {
            throw new HttpResponseException(
                response()->json(['errors' => $errors], 422)
            );
        }

        return $results;
    }
}