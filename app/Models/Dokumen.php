<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dokumen extends Model
{
    /**
     * Explicit table name to avoid incorrect pluralization
     */
    protected $table = 'dokumens';

    protected $fillable = [
        'user_id',
        'biodata_id',
        'nama_dokumen',
        'tipe_dokumen',
        'file_path',
        'status_verifikasi',
        'catatan_verifikasi',
        'diverifikasi_oleh',
        'tanggal_verifikasi',
    ];

    protected $casts = [
        'tanggal_verifikasi' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the dokumen
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the biodata that owns the dokumen
     */
    public function biodata(): BelongsTo
    {
        return $this->belongsTo(Biodata::class);
    }
}
