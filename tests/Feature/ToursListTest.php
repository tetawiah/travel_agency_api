<?php

namespace Tests\Feature;

use App\Models\Travel;
use App\Models\Tour;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ToursListTest extends TestCase
{
    use refreshDatabase;

    public function test_to_get_endpoint(): void
    {
        $travel = Travel::factory()->create();
        $response = $this->get("/api/v1/travels/$travel->slug/tours");
        $response->assertStatus(200);
    }

    public function test_to_get_list_of_tours() {
        $travel = Travel::factory()->create();
        Tour::factory(16)->create([
            'travel_id' => $travel->id,
        ]);
        $response = $this->get("/api/v1/travels/$travel->slug/tours");
        $response->assertJsonCount(15,'data');
    }

    public function test_to_get_working_pagination() {
        $travel = Travel::factory()->create();
        Tour::factory(16)->create([
            'travel_id' => $travel->id,
        ]);
        $response = $this->get("/api/v1/travels/$travel->slug/tours");
        $response->assertJsonFragment(['per_page' => 15]);
    }

    public function test_to_check_correct_price() {
        $travel = Travel::factory()->create();
        Tour::factory()->create([
            'travel_id' => $travel->id,
            'price' => 43.2,
        ]);
        $response = $this->get("/api/v1/travels/$travel->slug/tours");
        $response->assertJsonFragment(["price" => "43.20"]);
    }

}
