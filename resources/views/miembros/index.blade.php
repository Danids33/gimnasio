@extends('layouts.app')

@section('title', 'Listado de Miembros - PowerFit Gym')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    Gestión de Miembros
                </h4>
                <a href="{{ route('miembros.create') }}" class="btn btn-light btn-sm">
                    Nuevo Miembro
                </a>
            </div>
            <div class="card-body">
                @if($miembros->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nombre Completo</th>
                                    <th>Cédula</th>
                                    <th>Teléfono</th>
                                    <th>Tipo Membresía</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                    <th>Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($miembros as $miembro)
                                    <tr>
                                        <td>{{ $miembro->nombre_completo }}</td>
                                        <td>{{ $miembro->cedula }}</td>
                                        <td>
                                            <a href="tel:{{ $miembro->telefono }}" class="text-decoration-none">
                                                {{ $miembro->telefono }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $miembro->tipo_membresia }}</span>
                                        </td>
                                        <td>{{ $miembro->fecha_inicio->format('d/m/Y') }}</td>
                                        <td>{{ $miembro->fecha_fin->format('d/m/Y') }}</td>
                                        <td>
                                            @if($miembro->esta_activo)
                                                <span class="badge bg-success">
                                                    Activo
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    Vencido
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('miembros.show', $miembro->id) }}" 
                                                   class="btn btn-info" 
                                                   title="Ver detalles">
                                                    Ver
                                                </a>
                                                <a href="{{ route('miembros.edit', $miembro->id) }}" 
                                                   class="btn btn-warning" 
                                                   title="Editar">
                                                    Editar
                                                </a>
                                                <form action="{{ route('miembros.destroy', $miembro->id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('¿Está seguro de eliminar este miembro?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" title="Eliminar">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-3">
                        {{ $miembros->links() }}
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        No hay miembros registrados aún.
                        <a href="{{ route('miembros.create') }}" class="alert-link">Registrar primer miembro</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

