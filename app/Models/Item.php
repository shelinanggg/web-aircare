<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'qr_code',
        'name',
        'description',
        'category_id',
        'campus',
        'location_detail',
        'status',
        'image',
        'found_by',
        'found_date',
        'claimed_date',
        'claimed_by',
        'claimer_nim',
        'notes',
    ];

    protected $casts = [
        'found_date'   => 'date',
        'claimed_date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function logs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getCampusLabelAttribute(): string
    {
        return match ($this->campus) {

            'kampus-a' => 'Kampus A – Jl. Prof. Dr. Moestopo No.47',

            'kampus-b' => 'Kampus B – Jl. Dharmawangsa Dalam',

            'kampus-c' => 'Kampus C – Jl. Mulyorejo',

            default => ucfirst($this->campus),
        };
    }

    public function getCategoryLabelAttribute(): string
    {
        return $this->category?->name ?? 'Tidak Ada Kategori';
    }

    public function getCategoryColorAttribute(): string
    {
        return $this->category?->color ?? '#6B7280';
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {

            'found' => [
                'label' => 'Ditemukan',
                'class' => 'badge-found',
            ],

            'claimed' => [
                'label' => 'Diambil',
                'class' => 'badge-claimed',
            ],

            'disposed' => [
                'label' => 'Dimusnahkan',
                'class' => 'badge-disposed',
            ],

            'donated' => [
                'label' => 'Dihibahkan',
                'class' => 'badge-donated',
            ],

            'handed_over' => [
                'label' => 'Diserahkan ke DITPILAR',
                'class' => 'badge-handover',
            ],

            default => [
                'label' => ucfirst($this->status),
                'class' => '',
            ],
        };
    }

    /*
    |--------------------------------------------------------------------------
    | QR GENERATOR
    |--------------------------------------------------------------------------
    */

    public static function generateQrCode(): string
    {
        do {

            $code = 'ARC-' . strtoupper(
                substr(md5(uniqid(mt_rand(), true)), 0, 8)
            );

        } while (self::where('qr_code', $code)->exists());

        return $code;
    }
}