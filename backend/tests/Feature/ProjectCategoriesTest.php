<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectCategoriesTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function getAllProjectCategories()
    {
        $response = $this->json('GET', 'project/categories');

        // response should be HTTP 200
        $response->assertStatus(200);

    }


    /** @test */
    public function addProjectCategory()
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

        $response = $this->json('POST', 'project/categories',$category);

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
    public function addProjectCategoryAnonymous()
    {

        $category = [
            'category_name' => 'testName',
            'category_icon' => 'icon/test.svg'
        ];

        $response = $this->json('POST', 'project/categories',$category);

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
    public function updateProjectCategory()
    {

        //creating new category
        $this->addProjectCategory();

        $category = [
            'category_id' => '2',
            'category_name' => 'updatedTestName',
            'category_icon' => 'icon/test.svg'
        ];


        $response = $this->json('PUT', 'project/categories', $category);

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
    public function updateProjectCategoryAnonymous()
    {

        //creating new category

        $category = [
            'category_id' => '2',
            'category_name' => 'updatedTestName',
            'category_icon' => 'icon/test.svg'
        ];


        $response = $this->json('PUT', 'project/categories', $category);

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
    public function updateProjectCategoryNonExistent()
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
        $this->addProjectCategory();

        $category = [
            'category_id' => '0',
            'category_name' => 'updatedTestName',
            'category_icon' => 'icon/test.svg'
        ];


        $response = $this->json('PUT', 'project/categories', $category, ['Authorization' => 'Bearer' . $token]);

        // response should be HTTP 404
        $response->assertStatus(404);

    }

    /** @test */
    public function getProjectCategory()
    {
        $this->addProjectCategory();
        $response = $this->json('GET', 'project/categories/1');

        // response should be HTTP 200
        $response->assertStatus(200);

    }

    /** @test */
    public function deleteProjectCategoryAnonymous()
    {

        $response = $this->json('DELETE', 'project/categories/1');

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
    public function deleteProjectCategory()
    {
        $this->addProjectCategory();
        $response = $this->json('DELETE', 'project/categories/2');

        // response should be HTTP 500,
        // because there are subcategories that belong to this category
        $response->assertStatus(500);

    }


}
