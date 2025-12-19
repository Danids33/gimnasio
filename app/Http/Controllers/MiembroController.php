<?php

namespace App\Http\Controllers;

use App\Models\Miembro;
use Illuminate\Http\Request;

class MiembroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $miembros = Miembro::orderBy('created_at', 'desc')->paginate(10);
        return view('miembros.index', compact('miembros'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('miembros.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'cedula' => 'required|string|max:20|unique:miembros,cedula',
            'telefono' => 'required|string|max:20',
            'tipo_membresia' => 'required|string|max:50',
            'fecha_inscripcion' => 'nullable|date',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'esta_activo' => 'nullable|boolean',
        ], [
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'cedula.required' => 'La cédula es obligatoria.',
            'cedula.unique' => 'Esta cédula ya está registrada.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'tipo_membresia.required' => 'El tipo de membresía es obligatorio.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_fin.required' => 'La fecha de fin es obligatoria.',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
            'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
        ]);

        // Si no se proporciona fecha_inscripcion, usar la fecha actual
        if (empty($validated['fecha_inscripcion'])) {
            $validated['fecha_inscripcion'] = now();
        }

        Miembro::create($validated);

        return redirect()->route('miembros.index')
            ->with('success', 'Miembro registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $miembro = Miembro::findOrFail($id);
        return view('miembros.show', compact('miembro'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $miembro = Miembro::findOrFail($id);
        return view('miembros.edit', compact('miembro'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $miembro = Miembro::findOrFail($id);

        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'cedula' => 'required|string|max:20|unique:miembros,cedula,' . $id,
            'telefono' => 'required|string|max:20',
            'tipo_membresia' => 'required|string|max:50',
            'fecha_inscripcion' => 'required|date',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'esta_activo' => 'nullable|boolean',
        ], [
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'cedula.required' => 'La cédula es obligatoria.',
            'cedula.unique' => 'Esta cédula ya está registrada.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'tipo_membresia.required' => 'El tipo de membresía es obligatorio.',
            'fecha_inscripcion.required' => 'La fecha de inscripción es obligatoria.',
            'fecha_inscripcion.date' => 'La fecha de inscripción debe ser una fecha válida.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_fin.required' => 'La fecha de fin es obligatoria.',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
            'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
        ]);

        $miembro->update($validated);

        return redirect()->route('miembros.index')
            ->with('success', 'Miembro actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $miembro = Miembro::findOrFail($id);
        $miembro->delete();

        return redirect()->route('miembros.index')
            ->with('success', 'Miembro eliminado exitosamente (soft delete).');
    }
}
