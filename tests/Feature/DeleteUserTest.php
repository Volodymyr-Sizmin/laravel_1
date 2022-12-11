<?php

namespace Tests\Feature;

use App\Mail\DeletedUserMail;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\Passport;
use Mockery;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteuser()
    {
        Mail::fake();
        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->deleteJson("/api/auth/users/$user->id");
        Mail::assertSent(DeletedUserMail::class);
        $response->assertStatus(200);
    }
}
