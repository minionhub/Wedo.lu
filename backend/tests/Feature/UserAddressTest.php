<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserAddress;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserAddressTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function getAllUserAddresses()
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

        $response = $this->json('GET', 'user/address');

        // response should be HTTP 200
        $response->assertStatus(200);
    }


    /** @test */
    public function addUserAddress()
    {
        // create a test user
        $user = factory(User::class)->create([
            'email' => 'test-user2@wedo.lu',
        ]);

        // do post call with correct credentials to /api/login
        $response = $this->json('POST', 'login', [
            'email' => 'test-user2@wedo.lu',
            'password' => 'secret'
        ]);

        $testUserId = DB::table('users')->where('email', 'test-user2@wedo.lu')->first()->id;

        $userAddress = [
            'first_name' => 'test name',
            'last_name' => 'test name',
            'company_name' => 'test company name',
            'country' => 'France',
            'region' => '1',
            'street_name' => 'test street name',
            'house_number' => '10',
            'city' => 'luxembourg city',
            'zip' => '3000',
            'phone' => '1234567890',
            'email' => 'test@email.com',
            'address_type' => 'Billing',
            'user_id' => $testUserId
        ];

        $response = $this->json('POST', 'user/address', $userAddress);

        // response should be HTTP 201
        $response->assertStatus(201);

        // json response should only contain these attributes
        $response->assertJsonStructure([
            'data' => [
                'first_name',
                'last_name',
                'company_name',
                'country',
                'region',
                'street_name',
                'house_number',
                'city',
                'zip',
                'phone',
                'email',
                'address_type',
                'user_id',
                'created_at',
                'updated_at',
                'user_address_id'
            ]
        ]);
    }

    /** @test */
    public function addUserAddressAnonymous()
    {

        $userAddress = [
            'first_name' => 'test name',
            'last_name' => 'test name',
            'company_name' => 'test company name',
            'country' => 'France',
            'region' => 'lux',
            'street_name' => 'test street name',
            'house_number' => '10',
            'city' => 'luxembourg city',
            'zip' => '3000',
            'phone' => '1234567890',
            'email' => 'test@email.com',
            'address_type' => 'Billing',
            'user_id' => '10'
        ];

        $response = $this->json('POST', 'user/address', $userAddress);

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
    public function updateUserAddress()
    {
        //creating new address
        $this->addUserAddress();

        $testUserId = DB::table('users')->where('email', 'test-user2@wedo.lu')->first()->id;
        $testUserAddressId = UserAddress::all()->first()->user_address_id;

        $userAddress = [
            'user_address_id' => $testUserAddressId,
            'first_name' => 'test name',
            'last_name' => 'test name',
            'company_name' => 'test company name',
            'country' => 'France',
            'region' => '1',
            'street_name' => 'test street name',
            'house_number' => '10',
            'city' => 'luxembourg city',
            'zip' => '3000',
            'phone' => '1234567890',
            'email' => 'test@email.com',
            'address_type' => 'Billing',
            'user_id' => $testUserId
        ];


        $response = $this->json('PUT', 'user/address', $userAddress);

        // response should be HTTP 200
        $response->assertStatus(200);

        // json response should only contain these attributes
        $response->assertJsonStructure([
            'data' => [
                'user_address_id',
                'first_name',
                'last_name',
                'company_name',
                'country',
                'region',
                'street_name',
                'house_number',
                'city',
                'zip',
                'phone',
                'email',
                'address_type',
                'created_at',
                'updated_at',
                'user_id'
            ]
        ]);
    }

    /** @test */
    public function updateUserAddressAnonymous()
    {

        //creating new address

        $userAddress = [
            'user_address_id' => '1',
            'first_name' => 'test name',
            'last_name' => 'test name',
            'company_name' => 'test company name',
            'country' => 'France',
            'region' => 'lux',
            'street_name' => 'test street name',
            'house_number' => '10',
            'city' => 'luxembourg city',
            'zip' => '3000',
            'phone' => '1234567890',
            'email' => 'test@email.com',
            'address_type' => 'Billing',
            'user_id' => '10'
        ];

        $response = $this->json('PUT', 'user/address', $userAddress);

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
    public function updateUserAddressNonExistent()
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

        //creating new addess
        $this->addUserAddress();

        $userAddress = [
            'user_address_id' => '0',
            'first_name' => 'test name',
            'last_name' => 'test name',
            'company_name' => 'test company name',
            'country' => 'France',
            'region' => 'lux',
            'street_name' => 'test street name',
            'house_number' => '10',
            'city' => 'luxembourg city',
            'zip' => '3000',
            'phone' => '1234567890',
            'email' => 'test@email.com',
            'address_type' => 'Billing',
            'user_id' => '10'
        ];


        $response = $this->json('PUT', 'user/address', $userAddress);

        // response should be HTTP 404
        $response->assertStatus(404);
    }

    /** @test */
    public function getUserAddress()
    {
        $this->addUserAddress();

        // $testUserId = DB::table('users')->where('email', 'test-user2@wedo.lu')->first()->id;
        $testUserAddressId = UserAddress::all()->last()->user_address_id;

        $response = $this->json('GET', 'user/address/' . $testUserAddressId);

        // response should be HTTP 200
        $response->assertStatus(200);

        // json response should only contain these attributes
        $response->assertJsonStructure([
            'data' => [
                'user_address_id',
                'first_name',
                'last_name',
                'company_name',
                'country',
                'region',
                'street_name',
                'house_number',
                'city',
                'zip',
                'phone',
                'email',
                'address_type',
                'created_at',
                'updated_at',
                'user_id'
            ]
        ]);
    }

    /** @test */
    public function deleteUserAddressAnonymous()
    {

        $response = $this->json('DELETE', 'user/address/2');

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
    public function deleteUserAddress()
    {
        $this->addUserAddress();

        $testUserAddressId = UserAddress::all()->last()->user_address_id;

        $response = $this->json('DELETE', 'user/address/' . $testUserAddressId);

        // response should be HTTP 200
        $response->assertStatus(200);
    }
}
