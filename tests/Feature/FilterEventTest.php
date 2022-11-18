<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Event;
use Carbon\Carbon;

class FilterEventTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_has_filter_api()
    {
        $payload = [
            'selected' => "1"
        ];
        $response = $this->post('/api/filter', $payload);

        $response->assertStatus(200);
    }

    public function test_reset_filter()
    {
        $events = Event::factory()->count(100)->create();
        $payload = [
            'selected' => "0"
        ];
        $events_count = Event::all()->count();

        $response = $this->post('/api/filter', $payload)->decodeResponseJson();
        $this->assertEquals($response->count(), $events_count);
    }

    public function test_finished_events()
    {
        $events = Event::factory()->count(100)->create();
        $finished_events = Event::where('end_date', '<', date('Y-m-d'))->get()->count();

        $payload = [
            'selected' => "1"
        ];

        $response = $this->post('/api/filter', $payload)->decodeResponseJson();
        $this->assertEquals($finished_events, $response->count());
    }

    public function test_upcomming_events()
    {
        $events = Event::factory()->count(100)->create();
        $upcomming_events = Event::where('start_date', '>', date('Y-m-d'))->get()->count();

        $payload = [
            'selected' => "2"
        ];

        $response = $this->post('/api/filter', $payload)->decodeResponseJson();
        $this->assertEquals($upcomming_events, $response->count());
    }

    public function test_upcomming_events_within_7_days()
    {
        $events = Event::factory()->count(100)->create();
        $upcomming_events = Event::where('start_date', '>', date('Y-m-d'))->where('start_date', '<', Carbon::today()->addDays(7))->get()->count();

        $payload = [
            'selected' => "3"
        ];

        $response = $this->post('/api/filter', $payload)->decodeResponseJson();
        $this->assertEquals($upcomming_events, $response->count());
    }

    public function test_finished_events_of_last_7_days()
    {
        $events = Event::factory()->count(100)->create();
        $finished_events = Event::where('end_date', '<', date('Y-m-d'))->where('end_date', '>', Carbon::now()->subDays(7))->get()->count();

        $payload = [
            'selected' => "4"
        ];

        $response = $this->post('/api/filter', $payload)->decodeResponseJson();
        $this->assertEquals($finished_events, $response->count());
    }
}
