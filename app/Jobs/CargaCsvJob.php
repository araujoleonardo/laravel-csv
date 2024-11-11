<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use League\Csv\Reader;

class CargaCsvJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $path = public_path('csv/dataset.csv');
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(null);
        $csv->setDelimiter(',');

        $batchSize = 500;
        $rows = [];
        $processedRows = 0;

        foreach ($csv->getRecords() as $line) {
            $rows[] = [
                'coluna01' => $line[0],
                'coluna02' => $line[1],
                'coluna03' => $line[2],
                'coluna04' => $line[3],
                'coluna05' => $line[4],
                'coluna06' => $line[5],
                'coluna07' => $line[6],
                'coluna08' => $line[7],
            ];

            // Processa em lotes
            if (count($rows) === $batchSize) {
                try {
                    DB::table('colunas')->insert($rows);
                    $processedRows += count($rows);
                } catch (\Exception $e) {
                    Log::error('Falha ao inserir lote de dados: ' . $e->getMessage());

                    $rows = array_filter($rows, function($row) {
                        return !DB::table('colunas')->where($row)->exists();
                    });

                    if (!empty($rows)) {
                        DB::table('colunas')->insert($rows);
                        $processedRows += count($rows);
                    }
                } finally {
                    $rows = [];
                }
            }
        }

        if (!empty($rows)) {
            try {
                DB::table('colunas')->insert($rows);
            } catch (\Exception $e) {
                Log::error('Falha ao inserir lote final de dados: ' . $e->getMessage());

                $rows = array_filter($rows, function($row) {
                    return !DB::table('colunas')->where($row)->exists();
                });

                if (!empty($rows)) {
                    DB::table('colunas')->insert($rows);
                }
            }
        }

        Log::debug('Quantidade de linhas processadas: ' . $processedRows);
    }
}
