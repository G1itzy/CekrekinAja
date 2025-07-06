<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ForgetPasswordTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function user_can_request_reset_password_link()
    {
        // Create a test user
        $user = User::factory()->create([
            'email' => 'user@example.com',
        ]);

        // Fake email sending to prevent actual emails from being sent
        Mail::fake();

        // Send the request to reset password
        $response = $this->post(route('forgetpassword.sendlink'), [
            'email' => $user->email,
        ]);

        // Ensure user is redirected and success message is displayed
        $response->assertRedirect();
        $response->assertSessionHas('message', 'Silakan cek email Anda untuk reset password.');

        // Ensure that the reset password email was sent
        Mail::assertSent(function ($mail) use ($user) {
            // Check if the mail is being sent to the correct email address
            return $mail->hasTo($user->email) &&
                $mail->build()->getSubject() === 'Rental Kamera Online: Permintaan Reset Password';
        });
    }



    /** @test */
    public function user_cannot_request_reset_password_link_with_invalid_email()
    {
        // Fake email sending to prevent actual emails being sent
        Mail::fake();

        // Send the request with an invalid email (non-existing email)
        $response = $this->post(route('forgetpassword.sendlink'), [
            'email' => 'invalid@example.com', // Non-existing email
        ]);

        // Ensure the user is redirected back with errors
        $response->assertSessionHasErrors('email');

        // Ensure the redirection goes back to the forget password form
        $response->assertRedirect(route('forgetpassword.index')); // Ensure it's redirected back to the form

        // Ensure no email was sent
        Mail::assertNothingSent();
    }
}
