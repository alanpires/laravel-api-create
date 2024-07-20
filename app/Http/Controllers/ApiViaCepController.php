<?php

namespace App\Http\Controllers;

use App\Services\AddressService;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Teste Técnico - API Via CEP",
 *     version="1.0.0",
 *     description="This is a sample API documentation.",
 *     @OA\Contact(
 *         email="alancpires01@gmail.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 */
class ApiViaCepController extends Controller
{
    protected $adressService;

    public function __construct(AddressService $addressService) {
        $this->addressService = $addressService;
    }

    /**
     * @OA\Get(
     *     path="/search/local/{values}",
     *     summary="Get addresses by CEP",
     *     description="Returns a list of addresses based on the provided CEP values.",
     *     tags={"Addresses"},
     *     @OA\Parameter(
     *         name="values",
     *         in="path",
     *         description="Comma-separated list of CEP values",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A list of addresses",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="cep", type="string"),
     *                 @OA\Property(property="label", type="string"),
     *                 @OA\Property(property="logradouro", type="string"),
     *                 @OA\Property(property="complemento", type="string"),
     *                 @OA\Property(property="bairro", type="string"),
     *                 @OA\Property(property="localidade", type="string"),
     *                 @OA\Property(property="uf", type="string"),
     *                 @OA\Property(property="ibge", type="string"),
     *                 @OA\Property(property="gia", type="string"),
     *                 @OA\Property(property="ddd", type="string"),
     *                 @OA\Property(property="siafi", type="string"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error or failed to fetch data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Unexpected server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function getAddresses($values) 
    {
        try {
            $addressList = $this->addressService->getAddresses($values);
            return response()->json($addressList);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
