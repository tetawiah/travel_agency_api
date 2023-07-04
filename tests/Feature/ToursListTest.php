<?php

namespace Tests\Feature;

use App\Models\Travel;
use App\Models\Tour;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use PHPUnit\Util\Test;
use Tests\TestCase;
use Tests\TestHelper;

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

    public function test_to_sort_tours_list_by_price()
    {
        $travel = Travel::factory()->create();
        TestHelper::makeTour([
            'travel_id' => $travel->id,
            'price' => 20,
        ]);
        TestHelper::makeTour([
            'travel_id' => $travel->id,
            'price' => 55.2,
        ]);
        TestHelper::makeTour([
            'travel_id' => $travel->id,
            'price' => 98.9,
        ]);
        TestHelper::makeTour([
            'travel_id' => $travel->id,
            'price' => 12,
        ]);

        $response = $this->get("/api/v1/travels/$travel->slug/tours?sortby=price&sortOrder=desc");
        $response->assertJsonPath('data.0.price','98.90');
        $response->assertJsonPath('data.1.price','55.20');
        $response->assertJsonPath('data.3.price','12.00');
    }

    public function test_to_sort_tours_list_by_date()
    {
        $travel = Travel::factory()->create();
        $earlierDate = TestHelper::makeTour(['travel_id' => $travel->id,
            'start_date' => Carbon::now()->subDays(6)->format('Y-m-d'),
            'end_date' => Carbon::now()->subDays(4)->format('Y-m-d'),
            ]);

        $laterDate = TestHelper::makeTour([
            'travel_id' => $travel->id,
            'start_date' => Carbon::now()->subDays(3)->format('Y-m-d'),
            'end_date' => Carbon::now()->subDays(2)->format('Y-m-d'),
            ]);
        $response = $this->get("/api/v1/travels/$travel->slug/tours?sortby=start_date&sortOrder=desc");
        $response->assertJsonPath('data.0.startDate',$laterDate->start_date);
        $response->assertJsonPath('data.1.startDate',$earlierDate->start_date);

    }

    public function test_to_filter_tours_list_by_price()
    {
        $travel = Travel::factory()->create();
        $price1 = TestHelper::makeTour([
            'travel_id' => $travel->id,
            'price' => 20,
        ]);
        TestHelper::makeTour([
            'travel_id' => $travel->id,
            'price' => 55.2,
        ]);
        TestHelper::makeTour([
            'travel_id' => $travel->id,
            'price' => 98.9,
        ]);
        TestHelper::makeTour([
            'travel_id' => $travel->id,
            'price' => 12,
        ]);
        $response = $this->get("/api/v1/travels/$travel->slug/tours?priceFrom=56");
        $response->assertJsonCount(1,'data');
        $response->assertJsonMissing(['price' => $price1->price]);


    }

    public function test_to_filter_tours_list_by_date()
    {
        $travel = Travel::factory()->create();
        $earlierDate = TestHelper::makeTour(['travel_id' => $travel->id,
            'start_date' => Carbon::now()->subDays(6)->format('Y-m-d'),
            'end_date' => Carbon::now()->subDays(4)->format('Y-m-d'),
        ]);

        $laterDate = TestHelper::makeTour([
            'travel_id' => $travel->id,
            'start_date' => Carbon::now()->subDays(3)->format('Y-m-d'),
            'end_date' => Carbon::now()->subDays(2)->format('Y-m-d'),
        ]);
        $response = $this->get("/api/v1/travels/$travel->slug/tours?startDate=".Carbon::now()->subDays(3)->format('Y-m-d'));
        $response->assertJsonCount(1,'data');

    }

    public function test_tour_list_returns_validation_errors()
    {
        $travel = Travel::factory()->create();
        $this->get("/api/v1/travels/$travel->slug/tours?priceFrom=a")->assertSessionHasErrors();
        $this->getJson("/api/v1/travels/$travel->slug/tours?priceFrom=a")->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
