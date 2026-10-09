<?php

namespace App\Console\Commands;

use App\Services\LoginLocationUserDetails;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CompleteLoginLocationUsers extends Command
{
    protected $signature = 'login-locations:complete-users';
    protected $description = 'Completa nombre, RUN y unidades de accesos existentes desde generales y SIVEA';

    public function handle(LoginLocationUserDetails $details): int
    {
        $updated = 0;
        $pending = 0;
        DB::table('login_locations')->where(function ($query) {
            $query->whereNull('nombre_completo')->orWhereNull('rut')->orWhereNull('unidades');
        })->chunkById(200, function ($rows) use ($details, &$updated, &$pending) {
            $users = [];
            foreach ($rows as $row) {
                $data = $users[$row->user_id] ??= $details->forUserId((int) $row->user_id);
                // Preserve data already captured at the time of access.
                $missing = array_filter($data, fn ($value, $key) => $row->$key === null && $value !== null, ARRAY_FILTER_USE_BOTH);
                if ($missing) {
                    DB::table('login_locations')->where('id', $row->id)->update($missing);
                    $updated++;
                }
                if ($data['nombre_completo'] === null || $data['unidades'] === null) {
                    $pending++;
                }
            }
        });
        $this->info("Registros completados: {$updated}. Pendientes: {$pending}.");
        return $pending > 0 ? self::FAILURE : self::SUCCESS;
    }
}
