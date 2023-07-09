<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\TravelRequest;
use App\Models\Travel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;


class TravelController extends Controller
{
    public function index(Travel $travel) {
    }

    public function update(TravelRequest $request, Travel $travel) {
        $travel->update($request->validated());
        return response()->json(new TravelResource($travel),Response::HTTP_CREATED);
    }


}
