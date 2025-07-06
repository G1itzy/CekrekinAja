<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgetPasswordController extends Controller
{
    /**
     * Menampilkan form lupa password.
     */
    public function index()
    {
        return view('forgetpassword');
    }

    /**
     * Mengirim email berisi link reset password.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email tidak terdaftar dalam sistem kami.',
        ]);

        $token = Str::random(64);

        // Simpan token ke tabel password_resets
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        // Kirim email
        Mail::send('emails.forgetpassword', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Rental Kamera Online: Permintaan Reset Password');
        });

        return back()->with('message', 'Silakan cek email Anda untuk reset password.');
    }

    /**
     * Menampilkan form reset password.
     */
    public function resetPasswordIndex($token)
    {
        return view('resetpassword', ['token' => $token]);
    }

    /**
     * Menyimpan password baru dari form reset password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'                 => 'required|email|exists:users,email',
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
            'token'                 => 'required',
        ], [
            'email.exists' => 'Email tidak terdaftar dalam sistem kami.',
        ]);

        // Validasi token dan email dari tabel password_resets
        $resetEntry = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetEntry) {
            return back()->withInput()->with('error', 'Token tidak valid atau telah kedaluwarsa!');
        }

        // Ambil user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek apakah password baru sama dengan password lama
        if (Hash::check($request->password, $user->password)) {
            return back()->withInput()->withErrors([
                'password' => 'Password baru tidak boleh sama dengan password lama.',
            ]);
        }

        // Update password user
        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        // Hapus token reset password
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect(route('home'))->with('success_reset_password', 'Reset Password Berhasil!');
    }
}