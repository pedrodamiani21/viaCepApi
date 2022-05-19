<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViaCepController extends Controller
{
    public function getZipCodes($selectedZipCode){

        $separateZipCodes = explode(',', $selectedZipCode);
        $result = [];

        for($i = 0; $i < count($separateZipCodes); $i++)
        {
            $zipCode = $separateZipCodes[$i];
            $getViaCep = @file_get_contents("https://viacep.com.br/ws/$zipCode/json/");
            $data = json_decode($getViaCep, true);

            if(isset($data)){
                $splitData1 = array_slice($data, 0, 1 );
                $splitData2 = array_slice($data, 1 );
                $locality = $data["localidade"];
                $publicPlace = $data["logradouro"];
                $label = "$publicPlace, $locality";
                $splitData1['label'] = $label;
                array_push($result, array_merge($splitData1,$splitData2));
            }
        }
        return response($result);

    }
}

