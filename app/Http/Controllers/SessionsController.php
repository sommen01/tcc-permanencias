<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.login');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!auth()->attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'O seu usuário não foi encontrado.'
            ]);
        }

        session()->regenerate();

        return redirect('/tables');
    }

    public function show()
    {
        request()->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            request()->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function update()
    {
        request()->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            request()->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function destroy()
    {
        auth()->logout();

        return redirect('/sign-in');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $emailDomain = substr(strrchr($googleUser->getEmail(), "@"), 1);
    
            $allowedDomains = ['estudante.ifms.edu.br', 'ifms.edu.br'];
            if (!in_array($emailDomain, $allowedDomains)) {
                return redirect('/sign-in')->with('snackbar', 'Somente é permitido logar com conta institucional');
            }
    
            $user = User::where('email', $googleUser->getEmail())->first();
    
            $role = $emailDomain == 'estudante.ifms.edu.br' ? 'aluno' : 'professor';
    
            if ($user) {
                if (!$user->role) {
                    $user->role = $role;
                    $user->save();
                }
                Auth::login($user);
            } else {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(Str::random(16)),
                    'role' => $role,
                    'profile_completed' => $role == 'professor',
                ]);
    
                Auth::login($user);
            }
    
            if ($role == 'aluno' && !$user->profile_completed) {
                return redirect('/complete-profile');
            }
    
            return redirect()->route('tables'); 
        } catch (\Exception $e) {
            return redirect('/sign-in')->with('snackbar', 'Falha ao fazer login com Google: ' . $e->getMessage());
        }
    }
}
