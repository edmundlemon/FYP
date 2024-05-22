<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // use refreshDatabase;
    public function test_admin(): void
    {
        $admin = $this->postJson('/api/login', [
            'id' => 'AD1234',
            'password' => 'password'
        ]);
        $data = [
            'id' => 'AD1235',
            'name' => 'admin',
            'email' => 'admin2@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
        // Log::channel('api_post_log')->info('Admin created successfully', ['admin' => $admin]);
        $token = $admin['token'];
        Log::channel('api_post_log')->error('Token', ['token' => $token]);
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token,])->postJson('/api/register/admin', $data);
        Log::channel('api_post_log')->error('Response', ['response' => $response]);
        $response->assertStatus(201)->assertJson([
            'message' => 'Admin created successfully',
        ]);
    }

    public function test_delete_admin(): void
    {
        $admin = $this->postJson('/api/login', [
            'id' => 'AD1234',
            'password' => 'password'
        ]);
        $token = $admin['token'];
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token,])->deleteJson('/api/delete/admin/AD1235');
        $response->assertStatus(200)->assertJson([
            'message' => 'Admin deleted successfully',
        ]);
    }
}
