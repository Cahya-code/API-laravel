<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UjiHasil extends Model
{
    use HasFactory;

    protected $table = 'uji_hasil';

    protected $fillable = [
      'total', 'adduser', 'Nama_ujian', 'Kategori', 'id_user',
    ];

    public function User() {
      return $this->hasMany(User::class, 'id_user');
    }

}
