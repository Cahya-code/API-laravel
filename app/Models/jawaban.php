<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jawaban extends Model
{
    use HasFactory;

    protected $table = "jawabans";

    protected $fillable = [
      'answer', 'nilai_benar', 'soal_id'
    ];

    public function Soal() {
      return $this->belongsTo(Soal::class, 'soal_id');

    }
}
