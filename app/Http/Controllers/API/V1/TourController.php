<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetTravelToursRequest;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Support\Facades\DB;
use Ramsey\Collection\Collection;

class TourController extends Controller
{
    public function index(GetTravelToursRequest $request,Travel $travel)
    {
           $tours =  $travel->tours()
                ->when($request->filled('priceFrom'), function ($query) use ($request) {
                    return $query->where('price','>=',$request->priceFrom * 100);
            })
               ->when($request->filled('priceTo'),function ($query) use ($request) {
                   return $query->where('price','<=',$request->priceTo * 100);
               })
                ->when($request->filled('startDate'),function ($query) use ($request) {
                    return $query->where('start_date','>=',$request->startDate);
                })
               ->when($request->filled('endDate'),function ($query) use ($request) {
                     return $query->where('end_date', '<=', $request->endDate);
    })
               ->when($request->filled('sortby') && $request->filled('sortOrder'),function ($query) use ($request) {
                   return $query->orderby($request->sortby,$request->sortOrder);
               })
                ->paginate();

        return TourResource::collection($tours);
    }
}
