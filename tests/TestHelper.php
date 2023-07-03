<?php
namespace Tests;
use App\Models\Tour;
use App\Models\Travel;

class TestHelper {
    public static function makeTour(array $details)
    {
        return Tour::factory()->create($details);
    }
}
