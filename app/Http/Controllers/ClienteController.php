<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all()->map(function ($cliente) {
            return [
                'id' => $cliente->id,
                'nombre' => $cliente->nombre,
                'email' => $cliente->email
            ];
        });

        return response()->json($clientes);
    }

    public function create()
    {
        return Inertia::render('CreateUser');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clientes',
        ]);

        Cliente::create($validated);

        return redirect()->back()->with('success', 'Usuario creado exitosamente.');
    }
}
