<?php

namespace App\Http\Controllers;

use App\Jobs\CargaCsvJob;

class CargaController extends Controller
{
    public function carga(): void
    {
        CargaCsvJob::dispatch();

        echo 'Job disparado';
    }
}
