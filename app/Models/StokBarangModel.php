<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokBarangModel extends Model
{
    use HasFactory;

    protected $table = 't_stok'; // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'stok_id'; // Mendefinisikan primary key dari tabel yang digunakan
    protected $fillable = ['supplier_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah', 'created_at', 'updated_at']; // Kolom yang bisa diisi

    public function barang(): BelongsTo
    {
        return $this->belongsTo(BarangModel::class, 'barang_id', 'barang_id');
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }
    //Relasi ke tabel level
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(StokModel::class, 'supplier_id', 'supplier_id');
    }
    public function getRoleName(): string
    {
        return $this->stok->levelsupplier_nama;
    }
    public function hasRole($role): bool
    {
        return $this->stok->supplier_kode == $role;
    }
    public function getRole(){
        return $this->stok->supplier_alamat;
    }
}