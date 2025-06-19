<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuarios', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string|max:16|unique:usuarios,usuario',
            'nombre_asignado' => 'required|string|max:100',
            'cedula_asignado' => 'required|string|max:10',
            'clave' => 'required|string|max:16',
            'admin' => 'sometimes|boolean',
            'activo_inactivo' => 'sometimes|boolean'
        ]);

        Usuario::create([
            'usuario' => $request->usuario,
            'clave' => $request->clave, // ¡Considera usar hash en un futuro!
            'nombre_asignado' => $request->nombre_asignado,
            'cedula_asignado' => $request->cedula_asignado,
            'admin' => $request->has('admin') ? 1 : 0,
            'activo_inactivo' => 1,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function update(Request $request, $usuario_id)
    {
        $usuario = Usuario::findOrFail($usuario_id);

        $request->validate([
            'usuario' => 'required|string|max:16|unique:usuarios,usuario,' . $usuario_id . ',usuario_id',
            'nombre_asignado' => 'required|string|max:100',
            'cedula_asignado' => 'required|string|max:10',
            'clave' => 'nullable|string|max:16',
            'admin' => 'sometimes|boolean',
            'activo_inactivo' => 'sometimes|boolean'
        ]);

        $data = [
            'usuario' => $request->usuario,
            'nombre_asignado' => $request->nombre_asignado,
            'cedula_asignado' => $request->cedula_asignado,
            'admin' => $request->has('admin') ? 1 : 0,
            'activo_inactivo' => $request->has('activo_inactivo') ? 1 : 0,
        ];

        if ($request->filled('clave')) {
            $data['clave'] = $request->clave;
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($usuario_id)
    {
        $usuario = Usuario::findOrFail($usuario_id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}