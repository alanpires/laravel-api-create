<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\AddressService;
use Mockery;

class ApiViaCepControllerTest extends TestCase
{
    public function testGetAddresses()
    {
        $mockAddressService = Mockery::mock(AddressService::class);
        $mockAddressService->shouldReceive('getAddresses')
                           ->with('86990000,87033270')
                           ->andReturn([
                               [
                                   "cep" => "87033-270",
                                   "label" => "Rua Uruguai, Maringá",
                                   "logradouro" => "Rua Uruguai",
                                   "complemento" => "",
                                   "bairro" => "Jardim Alvorada",
                                   "localidade" => "Maringá",
                                   "uf" => "PR",
                                   "ibge" => "4115200",
                                   "gia" => "",
                                   "ddd" => "44",
                                   "siafi" => "7691"
                               ],
                               [
                                   "cep" => "86990-000",
                                   "label" => ", Marialva",
                                   "logradouro" => "",
                                   "complemento" => "",
                                   "bairro" => "",
                                   "localidade" => "Marialva",
                                   "uf" => "PR",
                                   "ibge" => "4114807",
                                   "gia" => "",
                                   "ddd" => "44",
                                   "siafi" => "7687"
                               ]
                           ]);

        $this->app->instance(AddressService::class, $mockAddressService);

        $response = $this->get('/search/local/86990000,87033270');

        $response->assertStatus(200);
        $response->assertJson([
            [
                "cep" => "87033-270",
                "label" => "Rua Uruguai, Maringá",
                "logradouro" => "Rua Uruguai",
                "complemento" => "",
                "bairro" => "Jardim Alvorada",
                "localidade" => "Maringá",
                "uf" => "PR",
                "ibge" => "4115200",
                "gia" => "",
                "ddd" => "44",
                "siafi" => "7691"
            ],
            [
                "cep" => "86990-000",
                "label" => ", Marialva",
                "logradouro" => "",
                "complemento" => "",
                "bairro" => "",
                "localidade" => "Marialva",
                "uf" => "PR",
                "ibge" => "4114807",
                "gia" => "",
                "ddd" => "44",
                "siafi" => "7687"
            ]
        ]);
    }

    public function testGetAddressWithInvalidCep() 
    {
        $response = $this->get('/search/local/invalid-cep');

        $response->assertStatus(422);
        $response->assertJson([
            'error' => 'Failed to fetch data for CEP: invalid-cep'
        ]);
    }

    public function testGetAddressesWithDifferentCepFormats()
    {
        $mockAddressService = Mockery::mock(AddressService::class);
        $mockAddressService->shouldReceive('getAddresses')
                        ->with('86990000,87033-270')
                        ->andReturn([
                            [
                                "cep" => "87033-270",
                                "label" => "Rua Uruguai, Maringá",
                                "logradouro" => "Rua Uruguai",
                                "complemento" => "",
                                "bairro" => "Jardim Alvorada",
                                "localidade" => "Maringá",
                                "uf" => "PR",
                                "ibge" => "4115200",
                                "gia" => "",
                                "ddd" => "44",
                                "siafi" => "7691"
                            ],
                            [
                                "cep" => "86990-000",
                                "label" => ", Marialva",
                                "logradouro" => "",
                                "complemento" => "",
                                "bairro" => "",
                                "localidade" => "Marialva",
                                "uf" => "PR",
                                "ibge" => "4114807",
                                "gia" => "",
                                "ddd" => "44",
                                "siafi" => "7687"
                            ]
                        ]);

        $this->app->instance(AddressService::class, $mockAddressService);

        $response = $this->get('/search/local/86990000,87033-270');
        
        $response->assertStatus(200);
        $response->assertJson([
            [
                "cep" => "87033-270",
                "label" => "Rua Uruguai, Maringá",
                "logradouro" => "Rua Uruguai",
                "complemento" => "",
                "bairro" => "Jardim Alvorada",
                "localidade" => "Maringá",
                "uf" => "PR",
                "ibge" => "4115200",
                "gia" => "",
                "ddd" => "44",
                "siafi" => "7691"
            ],
            [
                "cep" => "86990-000",
                "label" => ", Marialva",
                "logradouro" => "",
                "complemento" => "",
                "bairro" => "",
                "localidade" => "Marialva",
                "uf" => "PR",
                "ibge" => "4114807",
                "gia" => "",
                "ddd" => "44",
                "siafi" => "7687"
            ]
        ]);
    }

    public function testGetAddressesHandlesConnectionError()
    {
        $mockAddressService = Mockery::mock(AddressService::class);
        
        $mockAddressService->shouldReceive('getAddresses')
                           ->with('87033270,86990000')
                           ->andThrow(new \Exception('Connection error'));

        $this->app->instance(AddressService::class, $mockAddressService);

        $response = $this->get('/search/local/87033270,86990000');
        
        $response->assertStatus(500);
        $response->assertJson([
            'error' => 'Unexpected error occurred'
        ]);
    }
}