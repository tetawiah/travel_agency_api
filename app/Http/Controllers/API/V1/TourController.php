<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Support\Facades\DB;
use Ramsey\Collection\Collection;

class TourController extends Controller
{
    public function index(Travel $travel)
    {
        $request = request();
           $tours =  $travel->tours()
                ->when($request->filled('priceFrom') || $request->filled('priceTo'), function ($query) use ($request) {
                    return $query->where('price','>=',$request->priceFrom)
                        ->where('price','<=',$request->priceTo);
            })
                ->when($request->filled('startDate') || $request->filled('endDate'),function ($query) use ($request) {
                    return $query->where('start_date','>=',$request->startDate)
                        ->where('end_date', '<=', $request->endDate);
                })
               ->when($request->filled('sortby') && $request->filled('sortOrder'),function ($query) use ($request) {
                   return $query->orderby($request->sortby,$request->sortOrder);
               })
                ->get();

        return TourResource::collection($tours);
    }
}
