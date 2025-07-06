<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    public function testLoginWithValidCredentials()
    {
        echo "Login dengan kredensial valid diuji.\n";

        // Create a valid user (Super Admin)
        try {
            $user = User::factory()->create([
                'email' => 'alifnur@test.com',
                'password' => bcrypt('alifnur'), // Correct password (hashed)
                'role' => 2, // Super Admin
            ]);

            // Send the login request with valid credentials
            $response = $this->post('/login', [
                'email' => 'alifnur@test.com',
                'password' => 'alifnur', // Correct password
            ]);

            // Ensure the status is 302 (redirect)
            $response->assertStatus(302);

            // Ensure the user is redirected to the admin index page
            $response->assertRedirect(route('admin.index'));
        } catch (\Exception $e) {
            echo "Error during login with valid credentials: " . $e->getMessage() . "\n";
            throw $e; // Rethrow the exception to ensure the test fails if needed
        }
    }

    public function testLoginWithInvalidCredentials()
    {
        echo "Login dengan kredensial tidak valid diuji.\n";

        try {
            // Kirimkan login dengan email yang tidak terdaftar
            $response = $this->post('/login', [
                'email' => 'invalidemail@test.com', // Invalid email
                'password' => 'wrongpassword',  // Incorrect password
            ]);

            // Cek bahwa statusnya adalah redirect (302)
            $response->assertStatus(302);

            // Pastikan error ada untuk email (karena kredensial salah)
            $response->assertSessionHasErrors('email');
        } catch (\Exception $e) {
            echo "Error during login with invalid credentials: " . $e->getMessage() . "\n";
            throw $e; // Rethrow the exception to ensure the test fails if needed
        }
    }


    public function testLoginWithoutData()
    {
        echo "Login tanpa data diuji.\n";

        try {
            // Send an empty request (without email and password)
            $response = $this->post('/login', []);

            // Ensure validation errors are returned for 'email' and 'password'
            $response->assertSessionHasErrors(['email', 'password']);

            // Ensure the status is 302 (redirect)
            $response->assertStatus(302);
        } catch (\Exception $e) {
            echo "Error during login without data: " . $e->getMessage() . "\n";
            throw $e; // Rethrow the exception to ensure the test fails if needed
        }
    }

    public function testLoginWithOnlyEmail()
    {
        echo "Login dengan hanya email diuji.\n";

        try {
            // Send a request with only the email (no password)
            $response = $this->post('/login', [
                'email' => 'dimas@test.com',
                // No password sent
            ]);

            // Ensure there is an error for the 'password' field
            $response->assertSessionHasErrors('password');
            $response->assertStatus(302); // Ensure it's a redirect
        } catch (\Exception $e) {
            echo "Error during login with only email: " . $e->getMessage() . "\n";
            throw $e; // Rethrow the exception to ensure the test fails if needed
        }
    }

    public function testLoginWithWrongPassword()
{
    echo "Login dengan password yang salah diuji.\n";

    try {
        // Buat pengguna dengan password yang benar
        $user = User::factory()->create([
            'email' => 'dimas@test.com',
            'password' => bcrypt('dimas'), // Correct password (hashed)
        ]);

        // Kirimkan permintaan login dengan password yang salah
        $response = $this->post('/login', [
            'email' => 'dimas@test.com',
            'password' => 'asdmkvd', // Incorrect password
        ]);

        // Pastikan statusnya adalah redirect (302)
        $response->assertStatus(302);

        // Pastikan ada error untuk field password
        $response->assertSessionHasErrors('password');
    } catch (\Exception $e) {
        echo "Error during login with wrong password: " . $e->getMessage() . "\n";
        throw $e; // Rethrow the exception to ensure the test fails if needed
    }
}


    public function testLoginWithUnverifiedEmail()
    {
        echo "Login dengan email yang belum diverifikasi diuji.\n";

        try {
            // Buat pengguna dengan email yang belum diverifikasi
            $user = User::factory()->create([
                'email' => 'dimas@test.com',
                'password' => bcrypt('dimas'),
                'email_verified_at' => null, // No verification date
            ]);

            // Kirimkan permintaan login dengan email yang belum diverifikasi
            $response = $this->post('/login', [
                'email' => 'dimas@test.com',
                'password' => 'dimas',
            ]);

            // Pastikan ada error untuk email yang belum diverifikasi
            $response->assertSessionHasErrors('email');
            $response->assertStatus(302); // Pastikan ini redirect
        } catch (\Exception $e) {
            echo "Error during login with unverified email: " . $e->getMessage() . "\n";
            throw $e; // Rethrow the exception to ensure the test fails if needed
        }
    }


    public function testLoginRedirectsBasedOnRole()
    {
        echo "Login berdasarkan role diuji.\n";

        try {
            // Admin (role = 1)
            $admin = User::factory()->create([
                'email' => 'alifnur@test.com',
                'password' => bcrypt('alifnur'),
                'role' => 1
            ]);

            // Send login request as Admin
            $response = $this->post('/login', [
                'email' => 'wahyu@test.com',
                'password' => 'wahyu',
            ]);
            $response->assertRedirect(route('admin.index'));

            // Member (role = 0)
            $member = User::factory()->create([
                'email' => 'nufus@test.com',
                'password' => bcrypt('nufus'),
                'role' => 0
            ]);

            // Send login request as Member
            $response = $this->post('/login', [
                'email' => 'dimas@test.com',
                'password' => 'dimas',
            ]);
            $response->assertRedirect(route('member.index'));
        } catch (\Exception $e) {
            echo "Error during login based on role: " . $e->getMessage() . "\n";
            throw $e; // Rethrow the exception to ensure the test fails if needed
        }
    }
}
