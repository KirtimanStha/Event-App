<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Event;

class EventTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_events()
    {
        $response = $this->get('/api/events');

        $response->assertStatus(200);
    }

    public function test_create_event()
    {
        $old_count_events = Event::all()->count();
        $payload = [
            'title' => 'test title',
            'description' => 'this is test description',
            'start_date' => '2022-11-1',
            'end_date' => '2022-12-1'
        ];
        $response = $this->post('/api/events', $payload);
        $response->assertStatus(200);

        $count_events = Event::all()->count();
        // test by counting data after creating event
        $this->assertEquals($count_events, $old_count_events + 1);
    }

    public function test_create_event_validation_fail()
    {
        $payload = [
            'title' => 'test title'
        ];
        $response = $this->post('/api/events', $payload);

        $response->assertStatus(422);
    }

    public function test_show_event()
    {
        $event = Event::factory()->create();
        $response = $this->get('/api/events/'. $event->slug);

        $response->assertStatus(200);
    }

    public function test_event_not_found()
    {
        $response = $this->get('/api/events/1');

        $response->assertStatus(404);
    }

    public function test_update_event()
    {
        $event = Event::factory()->create();
        $payload = [
            'title' => 'test title',
            'description' => 'this is test description',
            'start_date' => '2022-11-1',
            'end_date' => '2022-12-1'
        ];
        $response = $this->patch('/api/events/'. $event->slug, $payload);

        // checks status with updated value
        $response->assertStatus(200)->assertJsonFragment($payload);
    }

    public function test_update_event_validation_fail()
    {
        $event = Event::factory()->create();
        $payload = [
            'title' => 'test title',
            'description' => 'test description',
            'start_date' => '2022/2/2',
            'end_date' => '2022/23/02'
        ];
        $response = $this->patch('/api/events/'. $event->slug, $payload);

        $response->assertStatus(422);
    }

    public function test_event_not_found_to_update()
    {
        $payload = [
            'title' => 'test title',
            'description' => 'this is test description',
            'start_date' => '2022-11-1',
            'end_date' => '2022-12-1'
        ];
        $response = $this->patch('/api/events/1', $payload);
        $response->assertStatus(404);
    }

    public function test_delete_event()
    {
        $event = Event::factory()->create();
        $oldcount = Event::all()->count();
        $response = $this->delete('/api/events/'. $event->slug);
        $response->assertStatus(200);

        $newcount = Event::all()->count();
        // test with counting after deletion
        $this->assertEquals($oldcount - 1, $newcount);

        $find_event = Event::find($event->id);
        // test record exists or not
        $this->assertFalse($find_event == null ? false : true);
    }

    public function test_event_not_found_to_delete()
    {
        $response = $this->delete('/api/events/1');

        $response->assertStatus(404);
    }
}
