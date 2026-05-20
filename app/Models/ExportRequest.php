<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExportRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'tracking_no', 'origin', 'destination_country', 'destination_city',
        'recipient_name', 'recipient_address', 'recipient_phone', 'goods_description',
        'goods_category', 'weight_kg', 'declared_value', 'currency', 'service_type',
        'status', 'notes', 'rejection_reason', 'approved_at', 'dispatched_at', 'delivered_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'dispatched_at' => 'datetime',
        'delivered_at' => 'datetime',
        'weight_kg' => 'decimal:3',
        'declared_value' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function trackings()
    {
        return $this->hasMany(ShipmentTracking::class)->latest();
    }

    public function latestTracking()
    {
        return $this->hasOne(ShipmentTracking::class)->latest();
    }

    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'pending' => 'badge-warning',
            'under_review' => 'badge-info',
            'approved' => 'badge-primary',
            'in_transit' => 'badge-indigo',
            'out_for_delivery' => 'badge-purple',
            'delivered' => 'badge-success',
            'rejected' => 'badge-danger',
            'cancelled' => 'badge-secondary',
            default => 'badge-secondary',
        };
    }

    public function getStatusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'under_review' => 'Under Review',
            'approved' => 'Approved',
            'in_transit' => 'In Transit',
            'out_for_delivery' => 'Out for Delivery',
            'delivered' => 'Delivered',
            'rejected' => 'Rejected',
            'cancelled' => 'Cancelled',
            default => ucfirst($this->status),
        };
    }
}
