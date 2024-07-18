<?php

namespace App\Http\Controllers;

use App\Models\Registrant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class RegistrantController extends Controller
{
    public function return_clean($data, $is_ieee)
    {
        $clean_data = [];

        $clean_data["name"] = $data[0]["value"];
        $clean_data["email"] = $data[1]["value"];
        $clean_data["phone"] = $data[2]["value"];
        $clean_data["gender"] = $data[3]["value"][0];
        $clean_data["course"] = $data[4]["value"];
        $clean_data["year"] = $data[5]["value"][0];
        $clean_data["t_shirt_size"] = $data[6]["value"][0];
        $clean_data["food_preference"] = $data[7]["value"][0];

        if(isset($data[9]) && $data[8]["value"][0] == "Others"){
            $clean_data["college_name"] = $data[9]["value"];
        }else{
            $clean_data["college_name"] = $data[8]["value"][0];
        }

        $clean_data["ticket_type"] = "Normal Registration";

        $clean_data["is_ieee_member"] = $is_ieee;

        return $clean_data;
    }

    public function data()
    {
        return Storage::json('data.json');
    }

    public function store_ieee(Request $request): JsonResponse|array
    {
        $data = $request->all()["webhook"]["answers"];

        $clean_data = $this->return_clean($data, true);

        $return_data =  [
            "message" => "success",
            "data" => $clean_data
        ];

        $year = $clean_data['year'];
        $course = $clean_data['course'];

        $clean_data = Arr::except($clean_data, ["year", "course"]);

        $registrant = Registrant::create($clean_data);

        $registrant->details()->create([
            'year' => $year,
            'course' => $course,
        ]);

        Storage::disk('local')->put('data.json', json_encode($return_data));

        return $return_data;
    }

    public function store_non_ieee(Request $request): JsonResponse|array
    {
        $data = $request->all()["webhook"]["answers"];

        $clean_data = $this->return_clean($data, false);

        $return_data = [
            "message" => "success",
            "data" => $clean_data
        ];

        $year = $clean_data['year'];
        $course = $clean_data['course'];

        $clean_data = Arr::except($clean_data, ["year", "course"]);

        $registrant = Registrant::create($clean_data);

        $registrant->details()->create([
            'year' => $year,
            'course' => $course,
        ]);

        Storage::disk('local')->put('data.json', json_encode($return_data));

        return $return_data;
    }
}
