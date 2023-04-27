<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function loginCorrectCredentials()
    {
        // create a test user
        $user = factory(User::class)->create([
            'email' => 'john1@wedo.lu',
        ]);

        // do post call with correct credentials to /api/login
        $response = $this->json('POST', 'login', [
            'email' => 'john1@wedo.lu',
            'password' => 'secret'
        ]);

        // response should be HTTP 200
        $response->assertStatus(200);

        // json response should contain these two attributes
        $response->assertJsonStructure([
            'status',
            'token'
        ]);

        // json response should have status key with value success
        $response->assertJson([
            'status' => 'success'
        ]);

        // json response's token key should not be empty
        $token = $response->json('token');
        $this->assertNotEmpty($token);
    }

    /** @test */
    public function loginIncorrectCredentials()
    {
        // create a test user
        $user = factory(User::class)->create([
            'email' => 'john1@wedo.lu',
        ]);

        // do post call with incorrect credentials to /api/login
        $response = $this->json('POST', 'login', [
            'email' => 'john1@wedo.lu',
            'password' => 'wrong'
        ]);

        // response should be HTTP 401
        $response->assertStatus(401);
    }

    /** @test */
    public function logout()
    {
        // create a test user
        $user = factory(User::class)->create([
            'email' => 'john1@wedo.lu',
        ]);

        // do post call with correct credentials to /api/login
        $response = $this->json('POST', 'login', [
            'email' => 'john1@wedo.lu',
            'password' => 'secret'
        ]);

        // do post call with freshly obtained token to /api/logout
        $response = $this->json('POST', 'logout');

        // response should be HTTP 200
        $response->assertStatus(200);

        // json response should contain these two attributes
        $response->assertJsonStructure([
            'status',
            'msg'
        ]);

        $response->assertJson([
            'status' => 'success',
            'msg' => 'Logged out successfully.'
        ]);
    }

    /** @test */
    public function logoutAnonymousUser()
    {
        // do post call without auth token to /api/logout
        $response = $this->json('POST', 'logout');

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
    public function getUser()
    {
        // create a test user
        $user = factory(User::class)->create([
            'email' => 'john1@wedo.lu',
        ]);

        // do post call with correct credentials to /api/login
        $response = $this->json('POST', 'login', [
            'email' => 'john1@wedo.lu',
            'password' => 'secret'
        ]);

        // do get call with freshly obtained token to /api/user
        $response = $this->json('GET', 'user');

        // response should be HTTP 200
        $response->assertStatus(200);

        // json response should only contain these attributes
        $response->assertJsonStructure([
            'status',
            'data' => [
                'id',
                'created_at',
                'updated_at',
                'first_name',
                'last_name',
                'nickname',
                'display_name',
                'email',
                'role'
            ]
        ]);

        // json response's keys should have these exact values
        $response->assertJson([
            'status' => 'success',
            'data' => [
                'email' => 'john1@wedo.lu',
                'role' => 'Regular'
            ]
        ]);
    }

    /** @test */
    public function getUserWhileBeingLoggedOut()
    {
        // do get call without token to /api/user
        $response = $this->json('GET', 'user');

        // response should be HTTP 400
        $response->assertStatus(400);

        // json response should only contain these attributes
        $response->assertJsonStructure([
            'error'
        ]);

        // json response's keys should have these exact values
        $response->assertJson([
            'error' => 'Unauthorized'
        ]);
    }

    /** @test */
    public function registerWithValidInfo() {
        $user = [
            'name' => 'Billy',
            'email' => 'billy@wedo.lu',
            'password' => 'Abcdefghi123'
        ];

        // do post call with valid info to /api/register
        $response = $this->json('POST', 'register', $user);

        // response should be HTTP 201
        $response->assertStatus(201);

        // json response should contain these 3 attributes
        $response->assertJsonStructure([
            'status',
            'user'=> [
                'display_name',
                'email',
                'updated_at',
                'created_at',
                'id'
            ],
            'token'
        ]);

        // json response should have status key with value success
        $response->assertJson([
            'status' => 'success'
        ]);

        // json response's token key should not be empty
        $token = $response->json('token');
        $this->assertNotEmpty($token);
    }

    /** @test */
    public function registerWithInvalidInfo() {
        $user = [
            'name' => '',
            'email' => 'billy.lu',
            'password' => 'abcdefg'
        ];

        // do post call with valid info to /api/register
        $response = $this->json('POST', 'register', $user);

        // response should be HTTP 400
        $response->assertStatus(400);

        // json response should contain these 2 attributes
        $response->assertJsonStructure([
            'status',
            'errors' => [
                'name',
                'email',
                'password'
            ]
        ]);

        // json response should contain validator errors
        $errors = $response->json('errors');
        $this->assertNotNull($errors);

        // there must be only one name error(required)
        $nameErrors = $response->json('errors.name');
        $this->assertEquals(1, count($nameErrors));

        // there must be only one email error(invalid format)
        $emailErrors = $response->json('errors.email');
        $this->assertEquals(1, count($emailErrors));

        // there must be 2 password errors(length, invalid format)
        $pwdErrors = $response->json('errors.password');
        $this->assertEquals(2, count($pwdErrors));

        // json response should have status key with value failure
        $response->assertJson([
            'status' => 'failure'
        ]);
    }

    /** @test */
    public function registerWithExistInfo() {
        // create a test user
        $userExist = factory(User::class)->create([
            'email' => 'john1@wedo.lu',
        ]);

        $user = [
            'name' => 'John',
            'email' => 'john1@wedo.lu',
            'password' => 'Abcdefghi123'
        ];

        // do post call with valid info to /api/register
        $response = $this->json('POST', 'register', $user);

        // response should be HTTP 400
        $response->assertStatus(400);

        // json response should contain these 2 attributes
        $response->assertJsonStructure([
            'status',
            'errors' => [
                'email',
                'exist'
            ]
        ]);

        // json response should have status key with value failure
        $response->assertJson([
            'status' => 'failure'
        ]);

        // json response should contain email validate errors
        $errors = $response->json('errors.exist');
        $this->assertNotNull($errors);
    }

    /** @test */
    public function changePasswordCorrectly()
    {
        // create a test user
        $user = factory(User::class)->create([
            'email' => 'john1@wedo.lu',
        ]);

        // do post call with correct credentials to /api/login
        $response = $this->json('POST', 'login', [
            'email' => 'john1@wedo.lu',
            'password' => 'secret'
        ]);

        $response = $this->json('PUT', 'password', [
            'currentPassword' => 'secret',
            'newPassword' => 'newSecret123'
        ]);

        // response should be HTTP 200
        $response->assertStatus(200);
    }

    /** @test */
    public function changePasswordWithoutToken()
    {
        // do post call as anonymous user
        $response = $this->json('PUT', 'password', [
            'currentPassword' => 'secret',
            'newPassword' => 'newSecret123'
        ]);

        // response should be HTTP 400
        $response->assertStatus(400);
    }

    /** @test */
    public function changePasswordWithCorrectTokenButWrongCurrentPassword()
    {
        // create a test user
        $user = factory(User::class)->create([
            'email' => 'john1@wedo.lu',
        ]);

        // do post call with correct credentials to /api/login
        $response = $this->json('POST', 'login', [
            'email' => 'john1@wedo.lu',
            'password' => 'secret'
        ]);

        // do post call with correct token to /api/password
        // but with wrong password
        $response = $this->json('PUT', 'password', [
            'currentPassword' => 'wrong',
            'newPassword' => 'newWrong1234'
        ]);

        // response should be HTTP 400
        $response->assertStatus(400);
    }

    /** @test */
    public function changePasswordToAWeakOne()
    {
        // create a test user
        $user = factory(User::class)->create([
            'email' => 'john1@wedo.lu',
        ]);

        // do post call with correct credentials to /api/login
        $response = $this->json('POST', 'login', [
            'email' => 'john1@wedo.lu',
            'password' => 'secret'
        ]);

        $response = $this->json('PUT', 'password', [
            'currentPassword' => 'secret',
            'newPassword' => 'weak'
        ]);

        // response should be HTTP 400
        $response->assertStatus(400);
    }
}
