<?php

namespace App\Services;

use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Illuminate\Support\Facades\Log;

class VisionService
{
    protected $vision;

    public function __construct()
    {
        $this->vision = new ImageAnnotatorClient([
            'credentials' => storage_path(env('GOOGLE_APPLICATION_CREDENTIALS')),
        ]);
    }

    /**
     * Cek konten aman/tidak dengan SafeSearch
     */
    public function detectUnsafeContent(string $filePath): array
    {
        $image = file_get_contents($filePath);
        $response = $this->vision->safeSearchDetection($image);
        $safe = $response->getSafeSearchAnnotation();

        return [
            'adult' => $safe->getAdult(),
            'violence' => $safe->getViolence(),
            'racy' => $safe->getRacy(),
            'medical' => $safe->getMedical(),
            'spoof' => $safe->getSpoof(),
        ];
    }

    /**
     * Return true kalau gambar dianggap tidak aman
     */
    public function isUnsafe(array $result): bool
    {
        // Threshold (Likely = 4, Very Likely = 5)
        return (
            ($result['adult'] >= 4) ||
            ($result['violence'] >= 4) ||
            ($result['racy'] >= 4)
        );
    }
}
