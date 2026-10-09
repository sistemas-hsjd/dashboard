<?php

namespace App\Services;

use App\Models\UserSivea;
use Illuminate\Support\Facades\DB;

class LoginLocationUserDetails
{
    public function forUserId(int $userId): array
    {
        $user = DB::connection('generales')->table('users')
            ->select('rut', 'nombre')->where('id', $userId)->first();

        if (!$user) {
            return ['nombre_completo' => null, 'rut' => null, 'unidades' => null];
        }

        $unidades = null;
        try {
            $siveaUser = filled($user->rut)
                ? UserSivea::with('unidades')->where('rut', $user->rut)->first()
                : null;
            $unidades = json_encode($siveaUser ? $siveaUser->unidades->map(fn ($unidad) => [
                'id' => $unidad->id,
                'nombre' => $unidad->tx_descripcion,
                'active' => (bool) $unidad->pivot->active,
            ])->values()->all() : [], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        } catch (\Throwable $exception) {
            // Keep the access log even if the separate SIVEA database is unavailable.
            // NULL can be retried later; [] means the lookup succeeded with no units.
            report($exception);
        }

        return [
            'nombre_completo' => $user->nombre,
            'rut' => $user->rut,
            'unidades' => $unidades,
        ];
    }
}
