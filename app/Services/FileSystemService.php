<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileSystemService
{
    const MAPPING_APP_ENV = [
        0 => 'AWS',
        1 => 'K5',
        2 => 'T2',
    ];

    const MAPPING_CONTRACT_SERVER = [
        0 => 'app1',
        1 => 'app2',
    ];
    /**
     * @throws \Exception
     */
    public function showSerialPaso(array $validated): array
    {
        $fileName = base64_decode($validated['file']);

        $pathFile = sprintf("%s/%s/%s.html", self::MAPPING_APP_ENV[$validated['app_env']],
            self::MAPPING_CONTRACT_SERVER[$validated['contract_server']], $fileName);

        if (!Storage::disk('local')->exists($pathFile)) {
            throw new \Exception('File not exits');
        }

        return ['fileName' => "$fileName.html", 'content' => base64_encode(Storage::disk('local')->get($pathFile))];
    }
}
