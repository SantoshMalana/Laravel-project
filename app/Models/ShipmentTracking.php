<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'export_request_id', 'status', 'location', 'description', 'updated_by',
    ];

    public function exportRequest()
    {
        return $this->belongsTo(ExportRequest::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
