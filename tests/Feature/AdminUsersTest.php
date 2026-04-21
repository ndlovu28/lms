<?php

namespace Tests\Feature;

use App\Livewire\Admin\AdminUsers;
use App\Models\Role;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminUsersTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles
        Role::create(['name' => 'su', 'description' => 'Super user']);
        Role::create(['name' => 'admin', 'description' => 'School admin']);
        Role::create(['name' => 'tutor', 'description' => 'Tutor']);
        Role::create(['name' => 'student', 'description' => 'Student']);
    }

    public function test_admin_can_open_create_user_modal(): void
    {
        $school = School::factory()->create();
        $adminRole = Role::where('name', 'admin')->first();
        $admin = User::factory()->create([
            'school_id' => $school->id,
            'role_id' => $adminRole->id,
        ]);

        Livewire::actingAs($admin)
            ->test(AdminUsers::class)
            ->call('openCreateUserModal')
            ->assertSet('showCreateUserModal', true);
    }

    public function test_admin_can_create_a_new_user(): void
    {
        $school = School::factory()->create();
        $adminRole = Role::where('name', 'admin')->first();
        $studentRole = Role::where('name', 'student')->first();
        $admin = User::factory()->create([
            'school_id' => $school->id,
            'role_id' => $adminRole->id,
        ]);

        Livewire::actingAs($admin)
            ->test(AdminUsers::class)
            ->set('name', 'John')
            ->set('surname', 'Doe')
            ->set('email', 'john.doe@example.com')
            ->set('password', 'password123')
            ->set('role_id', $studentRole->id)
            ->call('createUser')
            ->assertSet('showCreateUserModal', false)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('users', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'john.doe@example.com',
            'school_id' => $school->id,
            'role_id' => $studentRole->id,
            'status' => 1,
            'tutor_approved' => true,
        ]);
    }

    public function test_user_creation_validation(): void
    {
        $school = School::factory()->create();
        $adminRole = Role::where('name', 'admin')->first();
        $admin = User::factory()->create([
            'school_id' => $school->id,
            'role_id' => $adminRole->id,
        ]);

        Livewire::actingAs($admin)
            ->test(AdminUsers::class)
            ->call('createUser')
            ->assertHasErrors([
                'name' => 'required',
                'surname' => 'required',
                'email' => 'required',
                'password' => 'required',
                'role_id' => 'required',
            ]);
    }

    public function test_admin_cannot_create_user_with_existing_email(): void
    {
        $school = School::factory()->create();
        $adminRole = Role::where('name', 'admin')->first();
        $admin = User::factory()->create([
            'school_id' => $school->id,
            'role_id' => $adminRole->id,
        ]);

        User::factory()->create(['email' => 'existing@example.com']);

        Livewire::actingAs($admin)
            ->test(AdminUsers::class)
            ->set('name', 'John')
            ->set('surname', 'Doe')
            ->set('email', 'existing@example.com')
            ->set('password', 'password123')
            ->set('role_id', Role::where('name', 'student')->first()->id)
            ->call('createUser')
            ->assertHasErrors(['email' => 'unique']);
    }
}
