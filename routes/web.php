<?php

use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {

    $data = null;

    if($request->has("search")) {
        $weather = new \App\Utils\Sdk\Weather();
        $data = $weather->getWeatherData($request->get("search"));

        History::create([
            "search" => $request->get("search"),
            "temp" => $data->current_observation->condition->temperature
        ]);
    }

    $histories = History::query()->orderByDesc("created_at")->get();

    return view('welcome', compact("data", "histories"));
});
