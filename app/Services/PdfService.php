<?php

declare(strict_types=1);

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

final readonly class PdfService
{
    /**
     * Génère un PDF
     *
     * @param  bool  $download
     */
    public function generate(string $view, array $data, string $filename): Response
    {
        $pdf = Pdf::loadView($view, $data);

        return $pdf->stream($filename);
    }
}
