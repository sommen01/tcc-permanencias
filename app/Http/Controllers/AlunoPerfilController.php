<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlunoPerfilController extends Controller
{
    public function show()
    {
        return view('profile.complete');
    }

    public function store(Request $request)
    {
        $request->validate([
            'curso' => 'required|string|max:255',
            'periodo' => 'required|string|max:255',
            'turno' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->curso = $request->curso;
        $user->periodo = $request->periodo;
        $user->turno = $request->turno;
        $user->profile_completed = true; 
        $user->save();

        return redirect('/tables');
    }
}
