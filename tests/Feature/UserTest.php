<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function anybody_can_see_root_page()
    {
        $response = $this->get('/')
            ->assertStatus(200);
    }

    /** @test */
    public function anybody_can_see_teams_page()
    {
        $response = $this->get('/teams')
            ->assertOk();
    }

    /** @test */
    public function anybody_can_see_scoreboard_page()
    {
        $response = $this->get('/scoreboard')
            ->assertOk();
    }
        
    /** @test */
    public function only_logged_in_users_can_see_home_page()
    {
        $response = $this->get('/home')
            ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_can_see_home_page()
    {
        $this->actingAs(factory(User::class)->create(), 'api');

        $response = $this->get('/home')
            ->assertOk();
    }
    
}
