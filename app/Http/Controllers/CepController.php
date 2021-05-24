<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CepService;


class CepController extends Controller
{
    /**
     * GetAddress By CEP argument
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $cep
     * @return \Illuminate\Http\Response
     */
    public function getAddress(Request $request, string $cep)
    {
        //dump($cep);
        $service = new CepService();
        if (!is_object($service)) {
            return response()->json(null);
        }

        $addressData = $service->getAddressByCep($cep);
        if (!\is_array($addressData) || !array_key_exists('cep', $addressData)) {
            return response()->json(null);
        }

        $respData = [
            'endereco' => $addressData['address'],
            'bairro' => $addressData['district'],
            'cidade' => $addressData['city'],
            'estado' => $addressData['state'],
        ];

        return response()->json($respData);

    }


}
