<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EventTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function getAllEvents()
    {
        // get all events
        $response = $this->get('event');

        // response's status should be HTTP 200
        $response->assertStatus(200);

        $response->assertJson([
            'status' => 'success'
        ]);

        // json response should contain these attributes
        $response->assertJsonStructure([
            'status',
            'data' => [
                'current_page',
                'data' => [
                    [
                        'listing_id',
                        'logo_img',
                        'cover_img',
                        'full_description',
                        'slug',
                        'contact_email',
                        'region',
                        'title',
                        'tagLine',
                        'set_of_images',
                        'video_url',
                        'contact_phone',
                        'event_link',
                        'address',
                        'date_and_time',
                        'created_at',
                        'updated_at',
                        'company_id',
                        'user_id'
                    ]
                ],
                'first_page_url',
                'from',
                'last_page_url',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total'
            ]
        ]);

        // json response's keys should have these exact values
        $response->assertJson([
            'status' => 'success',
            'data' => [
                'current_page' => 1,
                'first_page_url' => 'http://wedotest:81/event?page=1',
                'from' => 1,
                'last_page' => 5,
                'last_page_url' => 'http://wedotest:81/event?page=5',
                'next_page_url' => 'http://wedotest:81/event?page=2',
                'path' => 'http://wedotest:81/event',
                'per_page' => 20,
                'prev_page_url' => null,
                'to' => 20,
                'total' => 100
            ]
        ]);
    }
}
