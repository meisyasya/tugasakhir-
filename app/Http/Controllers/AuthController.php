<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Mail\ResetPasswordMail;


class AuthController extends Controller
{
    // Menampilkan formulir login
    public function login()
    {
        return view('auth.login');
    }

     // Menangani percobaan login
     public function login_proses(Request $request)
     {
         // Validasi
         $request->validate([
             'email' => 'required|email',
             'password' => 'required|string|min:6',
         ]);
 
         // Pengecekan login
         if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $request->remember)) {
        
            $user = Auth::user();
        
            // Cek role dan redirect sesuai
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('bidan')) {
                return redirect()->route('bidan.dashboard'); // sesuaikan jika ada
            } elseif ($user->hasRole('pemdes')) {
                return redirect()->route('pemdes.dashboard'); // sesuaikan jika ada
            } elseif ($user->hasRole('kader')) {
                return redirect()->route('kader.dashboard'); // sesuaikan jika ada
            } elseif ($user->hasRole('ortu')) {
                return redirect()->route('ortu.dashboard'); // arahkan ke rute orang tua
            }
        
            // Jika role tidak dikenali
            return redirect()->route('login')->withErrors(['loginError' => 'Role tidak dikenali']);
        }
        
     }
 

    public function forgot_password(){
        return view('auth.forgot_password');
    } 

    
    public function forgot_password_act(Request $request)
{
    $customMessage = [
        'email.required' => 'Email tidak boleh kosong',
        'email.email' => 'Email tidak valid',
        'email.exists' => 'Email tidak terdaftar di database',
    ];

    // Validasi input email
    $request->validate([
        'email' => 'required|email|exists:users,email'
    ], $customMessage);

    // Generate token
    $token = \Str::random(60);

    // Cek apakah token valid
    if (!$token) {
        return back()->withErrors(['error' => 'Token gagal dibuat. Coba lagi.']);
    }

    // Cek apakah email valid
    if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
        return back()->withErrors(['email' => 'Email tidak valid.']);
    }

    // Simpan token ke database
    PasswordResetToken::updateOrCreate(
        [
            'email' => $request->email,
        ],
        [
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]
    );

    // Log token dan email untuk debugging
    Log::info('Token for email ' . $request->email . ': ' . $token);

    try {
        Mail::to($request->email)->send(new ResetPasswordMail($token));
        return redirect()->route('forgot-password')->with('success', 'Kami telah mengirimkan reset password ke email');
    } catch (\Exception $e) {
        Log::error('Email failed to send: ' . $e->getMessage());
        return back()->withErrors(['email' => 'Gagal mengirim email reset password. Coba lagi nanti.']);
    }
    
}




     public function validasi_forgot_password($token)
{
    $reset = PasswordResetToken::where('token', $token)->first();

    if (!$reset) {
        return redirect()->route('forgot-password')->with('error', 'Token tidak valid atau sudah kadaluarsa.');
    }

    return view('auth.mail.validasi_token', ['token' => $token]);
}

public function validasi_forgot_password_act(Request $request)
{
    $request->validate([
        'token' => 'required',
        'password' => 'required|min:6|confirmed',
    ]);

    $reset = DB::table('password_reset_tokens')->where('token', $request->token)->first();

    if (!$reset) {
        return back()->with('error', 'Token tidak valid atau sudah kadaluarsa.');
    }

    $user = User::where('email', $reset->email)->first();

    if (!$user) {
        return back()->with('error', 'Pengguna tidak ditemukan.');
    }

    $user->password = Hash::make($request->password);
    $user->save();

    DB::table('password_reset_tokens')->where('email', $reset->email)->delete();

    return redirect()->route('login')->with('success', 'Password berhasil direset. Silakan login.');
}


        
    public function register(){
        return view('auth.register');
    }

   // Menangani pendaftaran pengguna
public function register_proses(Request $request)
{
    // Validasi input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'nik' => 'required|string|max:20|unique:users,nik',
        'phone' => 'required|string|max:20',
    ]);

    // Membuat pengguna baru
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'nik' => $request->nik,
        'phone' => $request->phone,
    ]);

    // Memberikan role 'ortu' ke user baru
    $user->assignRole('ortu');

    // Redirect ke login (atau bisa login langsung)
    return redirect()->route('login')->with('success', 'Pendaftaran berhasil. Silakan login.');
}


   
    // Menangani logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda berhasil logout');
    }
}
