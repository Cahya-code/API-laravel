<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;

    protected $table = 'ujians';
    protected $fillable = [
      'nama_ujian' , 'tipe_ujian', 'mapel_id',
      'nama_user', 'id_user', 'mapel_name'];

    public function mapel()
    {
      return $this->belongsTo(mapel::class, 'mapel_id');
    }

    public function Soal ()
    {
      return $this->hasMany(Soal::class, 'ujian_id');
    }
}
