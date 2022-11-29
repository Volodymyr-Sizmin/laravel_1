<?php

namespace Tests\Unit;

use App\Mail\PasswordResetMail;
use App\Models\ResetPassword;
use App\Services\ResetPasswordService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class ResetPasswordServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_store_reset_token()
    {
//        $this->artisan('passport:install');

        $store = new ResetPasswordService();

        $token = Str::random(50);

        Mail::to('test@test.com')->send(new PasswordResetMail($token));

        ResetPassword::updateOrInsert(
            ['user_id' => 1],
            ['token' => $token, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

            $this->assertInstanceOf(ResetPasswordService::class, $store);

    }
}
