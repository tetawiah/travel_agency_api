<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Travel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;


class TravelController extends Controller
{
    public function index(Travel $travel) {
        $request = request();
        if ($request->has('priceFrom') || $request->has('priceTo')) {
            return Travel::query()->where('price','>=',$request->priceFrom)
                ->orWhere('price', '<=', $request->priceTo)->get();
        }

        if ($request->has('dateFrom') || $request->has('dateTo')) {
            return Travel::query()->where('dateFrom','>=',$request->start_date)
                ->orWhere('dateTo', '<=', $request->end_date)->get();
        }
       return TravelResource::collection($travel->tours()->get())->paginate();
    }

    public function show(Travel $travel) {
        return $travel->get();
    }
}
