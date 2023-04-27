<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class JobOfferTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function getAllJobOffers()
    {
        // get all job offers
        $response = $this->get('joboffer');

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
                        'job_function',
                        'contract_type',
                        'form_of_employment',
                        'pdf',
                        'payment',
                        'website_url',
                        'phone',
                        'map_longitude',
                        'map_latitude',
                        'offer_publisher_company',
                        'company_social_security_number',
                        'contact_person',
                        'level_of_luxembourgish',
                        'level_of_german',
                        'level_of_french',
                        'level_of_english',
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
                'first_page_url' => 'http://wedotest:81/joboffer?page=1',
                'from' => 1,
                'last_page' => 5,
                'last_page_url' => 'http://wedotest:81/joboffer?page=5',
                'next_page_url' => 'http://wedotest:81/joboffer?page=2',
                'path' => 'http://wedotest:81/joboffer',
                'per_page' => 20,
                'prev_page_url' => null,
                'to' => 20,
                'total' => 100
            ]
        ]);

        // it should return 20 companies per batch
        $response->assertJsonCount(20, 'data.data.*');
    }

    /** @test */
    public function getJobOfferById()
    {
        // get one job offer by id, the first one
        $response = $this->get('joboffer/id/1');

        // response's status should be HTTP 200
        $response->assertStatus(200);

        // json response should contain these attributes
        $response->assertJsonStructure([
            'status',
            'jobOffer' => [
                'listing_id',
                'logo_img',
                'cover_img',
                'full_description',
                'slug',
                'contact_email',
                'region',
                'job_function',
                'contract_type',
                'form_of_employment',
                'pdf',
                'payment',
                'website_url',
                'phone',
                'map_longitude',
                'map_latitude',
                'offer_publisher_company',
                'company_social_security_number',
                'contact_person',
                'level_of_luxembourgish',
                'level_of_german',
                'level_of_french',
                'level_of_english',
                'created_at',
                'updated_at',
                'company_id',
                'user_id'
            ]
        ]);

        // json response's keys should have these exact values
        $response->assertJson([
            'status' => 'success',
            'jobOffer' => [
                'listing_id' => '1',
                'created_at' => null,
                'updated_at' => null
            ]
        ]);
    }

    /** @test */
    public function getJobOfferBySlug() {

        // first get one job offer by id, the first one
        $responseById = $this->get('joboffer/id/1');
        $slug = $responseById->json('jobOffer.slug');

        // use the acquired slug (as all slugs are random)
        $responseBySlug = $this->get('joboffer/slug/' . $slug);

        // response's status should be HTTP 200
        $responseBySlug->assertStatus(200);

        // json response should contain these attributes
        $responseBySlug->assertJsonStructure([
            'status',
            'jobOffer' => [
                'listing_id',
                'logo_img',
                'cover_img',
                'full_description',
                'slug',
                'contact_email',
                'region',
                'job_function',
                'contract_type',
                'form_of_employment',
                'pdf',
                'payment',
                'website_url',
                'phone',
                'map_longitude',
                'map_latitude',
                'offer_publisher_company',
                'company_social_security_number',
                'contact_person',
                'level_of_luxembourgish',
                'level_of_german',
                'level_of_french',
                'level_of_english',
                'created_at',
                'updated_at',
                'company_id',
                'user_id'
            ]
        ]);

        // json response's keys should have these exact values
        $responseBySlug->assertJson([
            'status' => 'success',
            'jobOffer' => [
                'listing_id' => '1',
                'created_at' => null,
                'updated_at' => null
            ]
        ]);
    }

    /** @test */
    public function getJobOfferByUser() {

        // get one job offer by id, the first one
        $response = $this->get('joboffer/id/1');

        // response's status should be HTTP 200
        $response->assertStatus(200);
    }
}
