<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanySubCategoriesTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function getAllCompanySubCategories()
    {
        $response = $this->json('GET', 'company-subcategories');

        // response should be HTTP 200
        $response->assertStatus(200);

    }


    /** @test */
    public function addCompanySubCategory()
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
            'sub_category_name' => 'testName',
            'category_id' => '1'
        ];

        $response = $this->json('POST', 'company-subcategories',$category);

        // response should be HTTP 201
        $response->assertStatus(201);

        // json response should only contain these attributes
        $response->assertJsonStructure([
            'data' => [
                'sub_category_id',
                'sub_category_name',
                'created_at',
                'updated_at',
                'category_id'
            ]
        ]);

    }

    /** @test */
    public function addCompanyCategoryAnonymous()
    {

        $category = [
            'sub_category_name' => 'testName',
            'category_id' => '1'
        ];

        $response = $this->json('POST', 'company-subcategories',$category);

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
    public function updateCompanySubCategory()
    {

        //creating new category
        $this->addCompanySubCategory();

        $category = [
            'sub_category_id' => '1',
            'sub_category_name' => 'updatedTestName',
            'category_id' => '1'
        ];


        $response = $this->json('PUT', 'company-subcategories', $category);

        // response should be HTTP 200
        $response->assertStatus(200);

        // json response should only contain these attributes
        $response->assertJsonStructure([
            'data' => [
                'sub_category_id',
                'sub_category_name',
                'created_at',
                'updated_at',
                'category_id'
            ]
        ]);

    }

    /** @test */
    public function updateCompanySubCategoryAnonymous()
    {

        //creating new category

        $category = [
            'sub_category_id' => '1',
            'sub_category_name' => 'updatedTestName',
            'category_id' => '1'
        ];


        $response = $this->json('PUT', 'company-subcategories', $category);

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
    public function updateCompanySubCategoryNonExistent()
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
        $this->addCompanySubCategory();

        $category = [
            'sub_category_id' => '0',
            'sub_category_name' => 'updatedTestName',
            'category_id' => '1'
        ];


        $response = $this->json('PUT', 'company-subcategories', $category, ['Authorization' => 'Bearer' . $token]);

        // response should be HTTP 404
        $response->assertStatus(404);

    }

    /** @test */
    public function getCompanySubCategory()
    {
        $this->addCompanySubCategory();
        $response = $this->json('GET', 'company-subcategories/1');

        // response should be HTTP 200
        $response->assertStatus(200);

    }

    /** @test */
    public function deleteCompanySubCategoryAnonymous()
    {

        $response = $this->json('DELETE', 'company-subcategories/1');

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
    public function deleteCompanySubCategory()
    {
        $this->addCompanySubCategory();
        $response = $this->json('DELETE', 'company-subcategories/1');

        // response should be HTTP 500,
        // because there are companies that belong to this subcategory
        // so it can't be deleted like that
        $response->assertStatus(500);

    }
}
