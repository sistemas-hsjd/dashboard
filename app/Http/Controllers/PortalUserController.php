<?php

namespace App\Http\Controllers;

use App\Models\UserPortal;
use Illuminate\Http\Request;

class PortalUserController extends Controller
{
    public function index(Request $request)
    {
        abort_unless((int) $request->user()->id_perfil === 1, 403);

        $input = $request->validate(['q' => 'nullable|string|max:200']);
        $search = trim($input['q'] ?? '');
        $users = UserPortal::query()
            ->select(['id', 'rut', 'nombre', 'email_recuperacion', 'id_perfil', 'ultimo_acceso', 'password_txt'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('rut', 'like', '%' . $search . '%')
                        ->orWhere('nombre', 'like', '%' . $search . '%')
                        ->orWhere('email_recuperacion', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('nombre')->orderBy('id')->paginate(25)->withQueryString();

        return response()->view('usuarios.index', [
            'users' => $users, 'search' => $search, 'ip' => $request->ip(),
        ])->header('Cache-Control', 'no-store, private');
    }
}
