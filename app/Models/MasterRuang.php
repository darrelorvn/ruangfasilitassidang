<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterRuang extends Model
{
    use HasFactory;

    /**
     * Nama tabel database yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'master_ruang';

    /**
     * Primary key untuk tabel.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Format timestamp (false karena skema bawaan database.sql tidak menggunakan created_at & updated_at).
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Atribut yang dapat diisi secara mass assignment (CRUD).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_ruang',
        'gedung',
    ];
}
