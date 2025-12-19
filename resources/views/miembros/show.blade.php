@extends('layouts.app')

@section('title', 'Detalles del Miembro - PowerFit Gym')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
        <div class="card">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    Detalles del Miembro
                </h4>
                <div>
                    <a href="{{ route('miembros.edit', $miembro->id) }}" class="btn btn-warning btn-sm">
                        Editar
                    </a>
                    <a href="{{ route('miembros.index') }}" class="btn btn-light btn-sm">
                        Volver
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <div class="mb-3">
                            @if($miembro->esta_activo)
                                <span class="badge bg-success fs-6 px-4 py-2">
                                    Membresía Activa
                                </span>
                            @else
                                <span class="badge bg-danger fs-6 px-4 py-2">
                                    Membresía Vencida
                                </span>
                            @endif
                        </div>
                        <h3 class="mb-0">{{ $miembro->nombre_completo }}</h3>
                        <p class="text-muted mb-0">Cédula: {{ $miembro->cedula }}</p>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Nombre Completo:</strong>
                        <p class="mb-0">{{ $miembro->nombre_completo }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Cédula:</strong>
                        <p class="mb-0">{{ $miembro->cedula }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Teléfono:</strong>
                        <p class="mb-0">
                            <a href="tel:{{ $miembro->telefono }}" class="text-decoration-none">
                                {{ $miembro->telefono }}
                            </a>
                        </p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Tipo de Membresía:</strong>
                        <p class="mb-0">
                            <span class="badge bg-info">{{ $miembro->tipo_membresia }}</span>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <strong>Fecha de Inscripción:</strong>
                        <p class="mb-0">{{ $miembro->fecha_inscripcion->format('d/m/Y') }}</p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Fecha de Inicio:</strong>
                        <p class="mb-0">{{ $miembro->fecha_inicio->format('d/m/Y') }}</p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Fecha de Fin:</strong>
                        <p class="mb-0">
                            {{ $miembro->fecha_fin->format('d/m/Y') }}
                            @if($miembro->fecha_fin->isPast())
                                <span class="badge bg-danger ms-2">Vencida</span>
                            @elseif($miembro->fecha_fin->diffInDays(now()) <= 7)
                                <span class="badge bg-warning ms-2">Por vencer</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <strong>Días restantes:</strong>
                        <p class="mb-0">
                            @if($miembro->fecha_fin->isFuture())
                                <span class="badge bg-primary">
                                    {{ $miembro->fecha_fin->diffInDays(now()) }} días
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Vencida hace {{ $miembro->fecha_fin->diffInDays(now()) }} días
                                </span>
                            @endif
                        </p>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12">
                        <strong>Fechas de Registro:</strong>
                        <ul class="list-unstyled mb-0">
                            <li><small class="text-muted">Creado: {{ $miembro->created_at->format('d/m/Y H:i') }}</small></li>
                            <li><small class="text-muted">Última actualización: {{ $miembro->updated_at->format('d/m/Y H:i') }}</small></li>
                        </ul>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('miembros.index') }}" class="btn btn-secondary">
                        Volver al Listado
                    </a>
                    <div>
                        <a href="{{ route('miembros.edit', $miembro->id) }}" class="btn btn-warning">
                            Editar
                        </a>
                        <form action="{{ route('miembros.destroy', $miembro->id) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('¿Está seguro de eliminar este miembro?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

