<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Models\Travel;
use Ramsey\Collection\Collection;

class TourController extends Controller
{
    public function index(Travel $travel)
    {
        return TourResource::collection( $travel->tours()->orderBy('start_date')->paginate());
    }
}
