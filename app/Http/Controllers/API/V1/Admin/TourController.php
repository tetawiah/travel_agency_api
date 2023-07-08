<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourRequest;
use App\Http\Resources\TourResource;
use App\Http\Resources\TravelResource;
use App\Models\Travel;
use Illuminate\Http\Response;


class TourController extends Controller
{
    public function store(TourRequest $request,Travel $travel)
    {
        return response()->json(["data" => new TourResource($travel->tours()->create($request->validated())),
        "message" => "success"], Response::HTTP_CREATED);
    }
}
