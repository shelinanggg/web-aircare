<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'qr_code', 'name', 'description', 'category', 'campus',
        'location_detail', 'status', 'image', 'found_by', 'found_date',
        'claimed_date', 'claimed_by', 'claimer_nim', 'notes',
    ];

    protected $casts = [
        'found_date'   => 'date',
        'claimed_date' => 'date',
    ];

    public function logs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function getCampusLabelAttribute(): string
    {
        return match ($this->campus) {
            'kampus-a' => 'Kampus A – Dharmawangsa',
            'kampus-b' => 'Kampus B – Mulyorejo',
            'kampus-c' => 'Kampus C – Merr',
            default    => ucfirst($this->campus),
        };
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'electronics'  => 'Elektronik',
            'documents'    => 'Dokumen',
            'accessories'  => 'Aksesori',
            'bags'         => 'Tas & Dompet',
            'clothing'     => 'Pakaian',
            default        => 'Lainnya',
        };
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'found'    => ['label' => 'Ditemukan', 'class' => 'badge-found'],
            'claimed'  => ['label' => 'Diambil',   'class' => 'badge-claimed'],
            'disposed' => ['label' => 'Dimusnahkan','class' => 'badge-disposed'],
            default    => ['label' => $this->status, 'class' => ''],
        };
    }

    public static function generateQrCode(): string
    {
        do {
            $code = 'ARC-' . strtoupper(substr(md5(uniqid()), 0, 8));
        } while (self::where('qr_code', $code)->exists());

        return $code;
    }
}
