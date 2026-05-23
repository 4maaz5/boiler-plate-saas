<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProfilePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_authenticated_user_can_view_the_profile_page(): void
    {
        $user = User::factory()->create();
        Role::create(['name' => 'super_admin', 'guard_name' => 'web']);

        $user->assignRole('super_admin');

        $response = $this->actingAs($user)->get('/admin/profile');

        $response
            ->assertOk()
            ->assertSee(__('custom.password_security'))
            ->assertSee(__('custom.send_otp'));
    }
}
