<?php

namespace App\DTOs;

class AddressDTO
{
    public string $cep;
    public string $label;
    public string $logradouro;
    public string $complemento;
    public string $bairro;
    public string $localidade;
    public string $uf;
    public string $ibge;
    public string $gia;
    public string $ddd;
    public string $siafi;

    public function __construct(array $data)
    {
        $this->cep = $data['cep'] ?? '';
        $this->logradouro = $data['logradouro'] ?? '';
        $this->complemento = $data['complemento'] ?? '';
        $this->bairro = $data['bairro'] ?? '';
        $this->localidade = $data['localidade'] ?? '';
        $this->uf = $data['uf'] ?? '';
        $this->ibge = $data['ibge'] ?? '';
        $this->gia = $data['gia'] ?? '';
        $this->ddd = $data['ddd'] ?? '';
        $this->siafi = $data['siafi'] ?? '';

        $this->label = $this->logradouro . ', ' . $this->localidade;
    }
}
