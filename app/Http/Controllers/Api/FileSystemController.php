<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShowSerialPasoRequest;
use App\Services\FileSystemService;
use App\Traits\Api;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class FileSystemController extends Controller
{
    use Api;
    private FileSystemService $fileSystemService;
    public function __construct(FileSystemService $fileSystemService)
    {
        $this->fileSystemService = $fileSystemService;
    }

    public function showSerialPaso(ShowSerialPasoRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $dataFile = $this->fileSystemService->showSerialPaso($validated);

            return $this->responseFileSuccess($dataFile['fileName'], $dataFile['content']);

        }catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->responseFileError();
        }
    }
}
