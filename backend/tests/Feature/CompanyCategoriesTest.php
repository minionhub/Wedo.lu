<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanyCategoriesTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function getAllCompanyCategories()
    {
        $response = $this->json('GET', 'company-categories');

        // response should be HTTP 200
        $response->assertStatus(200);

    }


    /** @test */
    public function addCompanyCategory()
    {
        // create a test user
        $user = factory(User::class)->create([
            'email' => 'test-user@wedo.lu',
        ]);

        // do post call with correct credentials to /api/login
        $response = $this->json('POST', 'login', [
            'email' => 'test-user@wedo.lu',
            'password' => 'secret'
        ]);

        // using token
        $token = $response->json('token');
        $this->assertNotEmpty($token);

        $category = [
            'category_name' => 'testName',
            'category_icon' => 'icon/test.svg'
        ];

        $response = $this->json('POST', 'company-categories',$category);

        // response should be HTTP 201
        $response->assertStatus(201);

        // json response should only contain these attributes
        $response->assertJsonStructure([
            'data' => [
                'category_id',
                'category_name',
                'category_icon',
                'created_at',
                'updated_at'
            ]
        ]);

    }

    /** @test */
    public function addCompanyCategoryAnonymous()
    {

        $category = [
            'category_name' => 'testName',
            'category_icon' => 'icon/test.svg'
        ];

        $response = $this->json('POST', 'company-categories',$category);

        // response should be HTTP 400
        $response->assertStatus(400);

        // json response should contain these two attributes
        $response->assertJsonStructure([
            'error'
        ]);

        $response->assertJson([
            'error' => 'Unauthorized',
        ]);

    }

    /** @test */
    public function updateCompanyCategory()
    {

        //creating new category
        $this->addCompanyCategory();

        $category = [
            'category_id' => '2',
            'category_name' => 'updatedTestName',
            'category_icon' => 'icon/test.svg'
        ];


        $response = $this->json('PUT', 'company-categories', $category);

        // response should be HTTP 200
        $response->assertStatus(200);

        // json response should only contain these attributes
        $response->assertJsonStructure([
            'data' => [
                'category_id',
                'category_name',
                'category_icon',
                'created_at',
                'updated_at'
            ]
        ]);

    }

    /** @test */
    public function updateCompanyCategoryAnonymous()
    {

        //creating new category

        $category = [
            'category_id' => '2',
            'category_name' => 'updatedTestName',
            'category_icon' => 'icon/test.svg'
        ];

        $response = $this->json('PUT', 'company-categories', $category);

        // response should be HTTP 200
        $response->assertStatus(400);

        // json response should contain these two attributes
        $response->assertJsonStructure([
            'error'
        ]);

        $response->assertJson([
            'error' => 'Unauthorized',
        ]);

    }

    /** @test */
    public function updateCompanyCategoryNonExistent()
    {
        // create a test user
        $user = factory(User::class)->create([
            'email' => 'test-user@wedo.lu',
        ]);

        // do post call with correct credentials to /api/login
        $response = $this->json('POST', 'login', [
            'email' => 'test-user@wedo.lu',
            'password' => 'secret'
        ]);

        // using token
        $token = $response->json('token');
        $this->assertNotEmpty($token);

        //creating new category
        $this->addCompanyCategory();

        $category = [
            'category_id' => '0',
            'category_name' => 'updatedTestName',
            'category_icon' => 'icon/test.svg'
        ];


        $response = $this->json('PUT', 'company-categories', $category, ['Authorization' => 'Bearer' . $token]);

        // response should be HTTP 404
        $response->assertStatus(404);

    }

    /** @test */
    public function getCompanyCategory()
    {
        $this->addCompanyCategory();
        $response = $this->json('GET', 'company-categories/1');

        // response should be HTTP 200
        $response->assertStatus(200);

    }

    /** @test */
    public function deleteCompanyCategoryAnonymous()
    {

        $response = $this->json('DELETE', 'company-categories/1');

        // response should be HTTP 200
        $response->assertStatus(400);

        // json response should contain these two attributes
        $response->assertJsonStructure([
            'error'
        ]);

        $response->assertJson([
            'error' => 'Unauthorized',
        ]);

    }

    /** @test */
    public function deleteCompanyCategory()
    {
        $this->addCompanyCategory();
        $response = $this->json('DELETE', 'company-categories/2');

        // response should be HTTP 500,
        // because there are subcategories that belong to this category
        $response->assertStatus(500);
    }
}
