<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengumuman extends Model
{
    /**
     * Explicit table name to avoid incorrect pluralization
     */
    protected $table = 'pengumans';

    protected $fillable = [
        'user_id',
        'biodata_id',
        'nomor_pendaftaran',
        'nama_peserta',
        'status_hasil',
        'nilai_akhir',
        'pesan_pengumuman',
        'tanggal_pengumuman',
        'di_publikasikan',
    ];

    protected $casts = [
        'tanggal_pengumuman' => 'datetime',
        'di_publikasikan' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the pengumuman
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the biodata that owns the pengumuman
     */
    public function biodata(): BelongsTo
    {
        return $this->belongsTo(Biodata::class);
    }
}
