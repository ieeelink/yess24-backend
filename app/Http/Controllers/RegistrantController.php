<?php

namespace App\Http\Controllers;

use App\Models\Registrant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegistrantController extends Controller
{
    public function data()
    {
        return Storage::json('data.json');
    }

    public function store_ieee(Request $request): JsonResponse|array
    {
        $data = $request->all()["webhook"]["answers"];

        $return_data =  [
            "message" => "success",
            "data" => $data
        ];

        Storage::disk('local')->put('data.json', json_encode($return_data));

        return $return_data;
    }

    public function store_non_ieee(Request $request): JsonResponse|array
    {
        $data = $request->all()["webhook"]["answers"];

        return [
            "message" => "success",
            "data" => $data
        ];
    }
}
