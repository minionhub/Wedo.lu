<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function getAllCompanies()
    {
        // get all companies
        $response = $this->get('company');

        // response's status should be HTTP 200
        $response->assertStatus(200);

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
                        'company_name',
                        'key_words',
                        'short_desc',
                        'street',
                        'houseNbr',
                        'zip_code',
                        'city',
                        'map_longitude',
                        'map_latitude',
                        'set_of_images',
                        'phone',
                        'website_url',
                        'fax',
                        'e_commerce',
                        'social_networks',
                        'timezone',
                        'codeNace',
                        'commercialRegisterCode',
                        'internationalTVAnbr',
                        'nationalTVAnbr',
                        'revenue',
                        'shareCapital',
                        'employeeNbr',
                        'foundationDate',
                        'additionalDetails',
                        'brands',
                        'accepted_payment_methods',
                        'spoken_languages',
                        'certifications',
                        'facilities',
                        'is_premium_listing',
                        'created_at',
                        'updated_at',
                        'sub_category_id',
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
                'first_page_url' => 'http://wedotest:81/company?page=1',
                'from' => 1,
                'last_page' => 5,
                'last_page_url' => 'http://wedotest:81/company?page=5',
                'next_page_url' => 'http://wedotest:81/company?page=2',
                'path' => 'http://wedotest:81/company',
                'per_page' => 20,
                'prev_page_url' => null,
                'to' => 20,
                'total' => 100
            ]
        ]);

        // json response's token key should not be empty
        $status = $response->json('status');
        $this->assertNotEmpty($status);

        // it should return 20 companies per batch
        $response->assertJsonCount(20, 'data.data.*');
    }
}
