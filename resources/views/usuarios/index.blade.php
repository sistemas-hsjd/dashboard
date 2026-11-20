@extends('principal')

@section('contenido')
<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-3">Usuarios</h4>
        <form method="GET" action="{{ route('portalUsers.index') }}" class="row g-2 mb-3" role="search">
            <div class="col-md-8">
                <label for="user-search" class="form-label">Buscar por RUT, nombre o correo</label>
                <input id="user-search" type="search" name="q" value="{{ $search }}" maxlength="200" class="form-control">
            </div>
            <div class="col-md-4 d-flex align-items-end gap-2">
                <button class="btn btn-primary" type="submit">Buscar</button>
                <a class="btn btn-light" href="{{ route('portalUsers.index') }}">Limpiar</a>
            </div>
        </form>
        @error('q') <p class="text-danger">{{ $message }}</p> @enderror
        <p class="text-muted">{{ $users->total() }} usuarios encontrados</p>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead><tr>
                    <th scope="col">ID</th><th scope="col">RUT</th><th scope="col">Nombre</th>
                    <th scope="col">Correo de recuperación</th><th scope="col">Perfil</th>
                    <th scope="col">Último acceso</th><th scope="col">Contraseña (texto)</th>
                </tr></thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td><td>{{ $user->rut }}</td><td>{{ $user->nombre }}</td>
                            <td>{{ $user->email_recuperacion ?: 'Sin correo' }}</td>
                            <td>{{ (int) $user->id_perfil === 1 ? 'Administrador' : $user->id_perfil }}</td>
                            <td>{{ $user->ultimo_acceso ?: 'Sin registro' }}</td>
                            <td class="text-break"><span class="font-monospace">{{ $user->password_txt ?? 'No disponible' }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">No se encontraron usuarios.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
