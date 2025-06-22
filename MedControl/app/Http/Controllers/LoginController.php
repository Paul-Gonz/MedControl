<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required',
            'clave' => 'required'
        ]);

        $usuario = Usuario::where('usuario', $request->usuario)
            ->where('clave', $request->clave)
            ->where('activo_inactivo', 1)
            ->first();

        if ($usuario) {
            Session::put('usuario_id', $usuario->usuario_id);
            Session::put('usuario', $usuario->usuario);
            return redirect('/admin'); // O a donde quieras redirigir
        } else {
            return back()->withErrors(['usuario' => 'Usuario o clave incorrectos']);
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }
}