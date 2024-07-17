<?php

namespace App\Http\Controllers;

use App\Models\Registrant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\True_;

class RegistrantController extends Controller
{
    public function store_ieee(Request $request): JsonResponse|array
    {
        $data = $request->all()["webhook"]["answers"];

        return [
            "message" => "success",
            "data" => $data
        ];
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
