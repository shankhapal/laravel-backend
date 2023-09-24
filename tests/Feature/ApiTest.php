<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testApiEndpoint()
    {
        $response = $this->get('http://127.0.0.1:8000/api/users');

        $response->assertStatus(200); // Check if the response status is 200 (OK)
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'email',
                // Add more keys as needed based on your API response structure
            ],
        ]);
    }
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}