<?php

namespace App\Services;

use App\Models\Document;
use App\Models\ExportRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
    public function generate(ExportRequest $exportRequest, string $type): Document
    {
        $viewMap = [
            'invoice' => 'pdf.invoice',
            'customs_declaration' => 'pdf.customs_declaration',
            'manifest' => 'pdf.manifest',
            'packing_list' => 'pdf.packing_list',
            'certificate_of_origin' => 'pdf.certificate_of_origin',
        ];

        $view = $viewMap[$type] ?? 'pdf.invoice';
        $pdf = Pdf::loadView($view, compact('exportRequest'));

        $fileName = strtoupper($type).'_'.$exportRequest->tracking_no.'_'.now()->format('YmdHis').'.pdf';
        $filePath = 'documents/'.$fileName;

        Storage::disk('public')->put($filePath, $pdf->output());

        return Document::create([
            'export_request_id' => $exportRequest->id,
            'type' => $type,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'generated_at' => now(),
        ]);
    }

    public function generateAll(ExportRequest $exportRequest): array
    {
        $types = ['invoice', 'customs_declaration', 'manifest', 'packing_list'];
        $docs = [];
        foreach ($types as $type) {
            $docs[] = $this->generate($exportRequest, $type);
        }

        return $docs;
    }
}
