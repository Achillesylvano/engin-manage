<?php

declare(strict_types=1);

namespace App\Actions;

use App\Repositories\EntityRepository;
use App\Services\PdfService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Fluent;

class GeneratePdfAction
{
    public function __construct(
        protected EntityRepository $repository,
        protected PdfService $pdfService
    ) {}

    /**
     * Exécute la génération du PDF pour une entité
     *
     * @param  bool  $download
     */
    public function execute(Model $entity, Fluent $filters, string $view, string $filename): Response
    {
        $data = $this->repository->getFiltered($filters);

        return $this->pdfService->generate(
            $view,
            [
                'entity' => $entity,
                'data' => $data,
                'start_date' => $filters->get('start_date'),
                'end_date' => $filters->get('end_date'),
            ],
            $filename
        );
    }
}
