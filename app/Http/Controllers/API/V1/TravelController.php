<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Travel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;


class TravelController extends Controller
{
    public function index() {
       return TravelResource::collection(Travel::where('is_public',true)->paginate());
    }
}
