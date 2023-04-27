<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegionTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function getAllRegions()
    {
        $response = $this->get('region');
        $response->assertStatus(200);

        $response->assertJson([
            'status' => 'success'
        ]);

        $response->assertJsonStructure([
            'status',
            'data' => [
                [
                    'region_id',
                    'name',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);

        $response->assertJson([
            'status' => 'success'
        ]);
    }

    /** @test */
    public function getRegionById() {

        $testRegionId = DB::table('regions')->first()->region_id;

        $response = $this->get('region/' . $testRegionId);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            'region' => [
                'region_id',
                'name',
                'created_at',
                'updated_at'
            ]
        ]);

        $response->assertJson([
            'status' => 'success'
        ]);
    }
}
