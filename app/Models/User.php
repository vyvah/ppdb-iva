<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'provider',
        'provider_id',
        'is_verified',
        'otp_code',
        'otp_expires_at',
        // Document columns
        'kk',
        'akte',
        'bukti_transfer',
        // Parent/Guardian data
        'nama_ayah',
        'nik_ayah',
        'pekerjaan_ayah',
        'telepon_ayah',
        'nama_ibu',
        'nik_ibu',
        'pekerjaan_ibu',
        'telepon_ibu',
        'alamat_ortu',
        'rt_ortu',
        'rw_ortu',
        'kelurahan_ortu',
        'kecamatan_ortu',
        'kabupaten_ortu',
        'provinsi_ortu',
        'kode_pos_ortu',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke Biodata
     */
    public function biodata()
    {
        return $this->hasOne(Biodata::class);
    }
}
