<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use WithFaker;

    protected $headers = ['Accept' => 'application/json'];

    /**
     * A register feature test
     *
     * @return void
     */
    public function test_new_users_can_register()
    {
        $response = $this->withHeaders($this->headers)->postJson(route('auth.register'), [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertValid();
        $this->assertAuthenticated();
        $response->assertStatus(201);
        $response->assertJsonPath('message', 'Berhasil registrasi');
    }

    /**
     * A login without remember feature test
     *
     * @return void
     */
    public function test_users_can_login_without_remember()
    {
        $user = User::latest()->first();
        $response = $this->withHeaders($this->headers)->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
            'remember' => false
        ]);

        $this->assertAuthenticated();
        $response->assertStatus(200);
        $response->assertJsonPath('message', 'Berhasil login');
        $response->assertJsonPath('data.authorization.expired', 3600);
    }

    /**
     * A login with remember feature test
     *
     * @return void
     */
    public function test_users_can_login_with_remember()
    {
        $user = User::latest()->first();
        $response = $this->withHeaders($this->headers)->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
            'remember' => true
        ]);

        $this->assertAuthenticated();
        $response->assertStatus(200);
        $response->assertJsonPath('message', 'Berhasil login');
        $response->assertJsonPath('data.authorization.expired', 43200);
    }

    /**
     * A get own user data feature test
     *
     * @return void
     */
    public function test_users_can_get_their_own_data()
    {
        $user = User::latest()->first();
        $response = $this->actingAs($user)->withHeaders($this->headers)->getJson(route('auth.data'));

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Berhasil mendapatkan data user']);
    }

    /**
     * A refresh token feature test
     *
     * @return void
     */
    public function test_users_can_refresh_their_token()
    {
        $user = User::latest()->first();
        $response = $this->actingAs($user)->withHeaders($this->headers)->postJson(route('auth.refresh'));

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Berhasil merefresh token']);
    }

    /**
     * A logout feature test
     *
     * @return void
     */
    public function test_users_can_logout()
    {
        $user = User::latest()->first();
        $response = $this->actingAs($user)->withHeaders($this->headers)->postJson(route('auth.logout'));

        $this->assertGuest();
        $response->assertStatus(200);
        $response->assertJsonPath('message', 'Berhasil logout');
    }
}
