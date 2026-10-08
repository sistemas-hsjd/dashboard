<?php

namespace App\Services;

use RuntimeException;

class VisitCounter
{
    public function increment(): int
    {
        // Keep the total outside the cache so cache:clear does not reset it.
        $file = fopen(storage_path('app/portal-visits.txt'), 'c+');

        if ($file === false) {
            throw new RuntimeException('No se pudo abrir el contador de visitas.');
        }

        try {
            if (!flock($file, LOCK_EX)) {
                throw new RuntimeException('No se pudo bloquear el contador de visitas.');
            }

            $total = max(0, (int) trim(stream_get_contents($file))) + 1;
            rewind($file);
            $value = (string) $total;

            if (fwrite($file, $value) !== strlen($value) || !ftruncate($file, strlen($value)) || !fflush($file)) {
                throw new RuntimeException('No se pudo guardar el contador de visitas.');
            }

            return $total;
        } finally {
            flock($file, LOCK_UN);
            fclose($file);
        }
    }
}
