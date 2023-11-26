<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;
    protected $table ="soals";

    protected $fillable =['soal_text' , 'ujian_id', 'Kunci_jawaban'];

    public function Ujian()
    {
    return $this->belongsTo(Ujian::class, 'ujian_id');
    }

    public function jawaban()
    {
      return $this->hasMany(jawaban::class, 'soal_id');
    }
}
