@extends('layouts.app')

@section('title', 'Editar Miembro - PowerFit Gym')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">
                    Editar Miembro
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('miembros.update', $miembro->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre_completo" class="form-label">
                                Nombre Completo <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nombre_completo') is-invalid @enderror" 
                                   id="nombre_completo" 
                                   name="nombre_completo" 
                                   value="{{ old('nombre_completo', $miembro->nombre_completo) }}" 
                                   required>
                            @error('nombre_completo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="cedula" class="form-label">
                                Cédula <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('cedula') is-invalid @enderror" 
                                   id="cedula" 
                                   name="cedula" 
                                   value="{{ old('cedula', $miembro->cedula) }}" 
                                   required>
                            @error('cedula')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telefono" class="form-label">
                                Teléfono <span class="text-danger">*</span>
                            </label>
                            <input type="tel" 
                                   class="form-control @error('telefono') is-invalid @enderror" 
                                   id="telefono" 
                                   name="telefono" 
                                   value="{{ old('telefono', $miembro->telefono) }}" 
                                   required>
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tipo_membresia" class="form-label">
                                Tipo de Membresía <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('tipo_membresia') is-invalid @enderror" 
                                    id="tipo_membresia" 
                                    name="tipo_membresia" 
                                    required>
                                <option value="">Seleccione...</option>
                                <option value="Mensual" {{ old('tipo_membresia', $miembro->tipo_membresia) == 'Mensual' ? 'selected' : '' }}>Mensual</option>
                                <option value="Trimestral" {{ old('tipo_membresia', $miembro->tipo_membresia) == 'Trimestral' ? 'selected' : '' }}>Trimestral</option>
                                <option value="Semestral" {{ old('tipo_membresia', $miembro->tipo_membresia) == 'Semestral' ? 'selected' : '' }}>Semestral</option>
                                <option value="Anual" {{ old('tipo_membresia', $miembro->tipo_membresia) == 'Anual' ? 'selected' : '' }}>Anual</option>
                            </select>
                            @error('tipo_membresia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="fecha_inscripcion" class="form-label">
                                Fecha de Inscripción <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control @error('fecha_inscripcion') is-invalid @enderror" 
                                   id="fecha_inscripcion" 
                                   name="fecha_inscripcion" 
                                   value="{{ old('fecha_inscripcion', $miembro->fecha_inscripcion->format('Y-m-d')) }}"
                                   required>
                            @error('fecha_inscripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="fecha_inicio" class="form-label">
                                Fecha de Inicio <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control @error('fecha_inicio') is-invalid @enderror" 
                                   id="fecha_inicio" 
                                   name="fecha_inicio" 
                                   value="{{ old('fecha_inicio', $miembro->fecha_inicio->format('Y-m-d')) }}" 
                                   required>
                            @error('fecha_inicio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="fecha_fin" class="form-label">
                                Fecha de Fin <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control @error('fecha_fin') is-invalid @enderror" 
                                   id="fecha_fin" 
                                   name="fecha_fin" 
                                   value="{{ old('fecha_fin', $miembro->fecha_fin->format('Y-m-d')) }}" 
                                   required>
                            @error('fecha_fin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="esta_activo" 
                                       name="esta_activo" 
                                       value="1" 
                                       {{ old('esta_activo', $miembro->esta_activo) ? 'checked' : '' }}>
                                <label class="form-check-label" for="esta_activo">
                                    Membresía Activa
                                </label>
                            </div>
                            <small class="form-text text-muted">Se actualizará automáticamente según la fecha de fin</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('miembros.index') }}" class="btn btn-secondary">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-warning">
                            Actualizar Miembro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-calcular fecha de fin basándose en tipo de membresía
    document.getElementById('tipo_membresia').addEventListener('change', function() {
        const fechaInicio = document.getElementById('fecha_inicio').value;
        if (!fechaInicio) return;

        const fechaInicioObj = new Date(fechaInicio);
        const tipo = this.value;
        let meses = 0;

        switch(tipo) {
            case 'Mensual': meses = 1; break;
            case 'Trimestral': meses = 3; break;
            case 'Semestral': meses = 6; break;
            case 'Anual': meses = 12; break;
        }

        if (meses > 0) {
            fechaInicioObj.setMonth(fechaInicioObj.getMonth() + meses);
            const fechaFin = fechaInicioObj.toISOString().split('T')[0];
            document.getElementById('fecha_fin').value = fechaFin;
        }
    });
</script>
@endpush

