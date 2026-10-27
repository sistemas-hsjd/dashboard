<?php

namespace App\Http\Controllers;

use App\Models\LoginLocation;
use Illuminate\Http\Request;

class LoginLocationController extends Controller
{
    public function realtimeConfig(Request $request)
    {
        abort_unless((int) $request->user()->id_perfil === 1, 403);

        return response()->json([
            'key' => config('broadcasting.connections.pusher.key'),
            'cluster' => config('broadcasting.connections.pusher.options.cluster'),
        ]);
    }

    public function index(Request $request)
    {
        abort_unless((int) $request->user()->id_perfil === 1, 403);
        $ip = $request->ip();
        return view('contenido.contenido', compact('ip'));
    }

    public function data(Request $request)
    {
        abort_unless((int) $request->user()->id_perfil === 1, 403);
        $input = $request->validate([
            'draw' => 'nullable|integer|min:0', 'start' => 'nullable|integer|min:0',
            'length' => 'nullable|integer|between:1,100', 'search.value' => 'nullable|string|max:200',
            'status' => 'nullable|in:success,denied,unavailable,timeout,unsupported,insecure',
            'from' => 'nullable|date_format:Y-m-d', 'to' => 'nullable|date_format:Y-m-d|after_or_equal:from',
            'order.0.column' => 'nullable|integer|min:0', 'order.0.dir' => 'nullable|in:asc,desc',
        ]);
        $query = LoginLocation::query();
        $total = (clone $query)->count();
        $latestId = (clone $query)->max('id') ?? 0;
        if ($request->filled('status')) $query->where('location_status', $input['status']);
        if ($request->filled('from')) $query->where('logged_in_at', '>=', \Carbon\Carbon::parse($input['from'], 'America/Santiago')->startOfDay()->setTimezone(config('app.timezone')));
        if ($request->filled('to')) $query->where('logged_in_at', '<', \Carbon\Carbon::parse($input['to'], 'America/Santiago')->addDay()->startOfDay()->setTimezone(config('app.timezone')));
        $term = trim($input['search']['value'] ?? '');
        if ($term !== '') {
            $query->where(function ($search) use ($term) {
                foreach (['nombre_completo', 'rut', 'ip_address', 'location_status', 'unidades', 'operating_system'] as $column) {
                    $search->orWhere($column, 'like', '%' . $term . '%');
                }
            });
        }
        $filtered = (clone $query)->count();
        $columns = [0 => 'id', 1 => 'logged_in_at', 2 => 'nombre_completo', 3 => 'rut', 6 => 'ip_address', 7 => 'location_status', 8 => 'operating_system'];
        $column = $columns[$input['order'][0]['column'] ?? 1] ?? 'logged_in_at';
        $query->orderBy($column, $input['order'][0]['dir'] ?? 'desc');
        if ($column !== 'id') $query->orderByDesc('id');
        $rows = $query->skip($input['start'] ?? 0)->take($input['length'] ?? 25)->get();
        $estamentosDisponibles = true;
        try {
            $rows->load('siveaUser.estamento');
        } catch (\Throwable $exception) {
            report($exception);
            $estamentosDisponibles = false;
        }
        $rows = $rows->map(function ($row) use ($estamentosDisponibles) {
            $data = $row->attributesToArray();
            $data['estamento'] = $estamentosDisponibles
                ? ($row->siveaUser?->estamento?->tx_descripcion ?? 'Sin estamento')
                : 'No disponible';
            $data['logged_in_at'] = $row->logged_in_at?->timezone('America/Santiago')->format('d-m-Y H:i:s');
            return $data;
        });
        return response()->json(['draw' => (int) ($input['draw'] ?? 0), 'recordsTotal' => $total, 'recordsFiltered' => $filtered, 'latest_id' => $latestId, 'data' => $rows]);
    }
}
