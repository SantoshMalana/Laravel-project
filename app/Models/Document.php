<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'export_request_id', 'type', 'file_path', 'file_name', 'generated_at',
    ];

    protected $casts = [
        'generated_at' => 'datetime',
    ];

    public function exportRequest()
    {
        return $this->belongsTo(ExportRequest::class);
    }

    public function getTypeLabel(): string
    {
        return match ($this->type) {
            'invoice' => 'Commercial Invoice',
            'customs_declaration' => 'Customs Declaration',
            'manifest' => 'Shipment Manifest',
            'packing_list' => 'Packing List',
            'certificate_of_origin' => 'Certificate of Origin',
            default => ucfirst(str_replace('_', ' ', $this->type)),
        };
    }
}
