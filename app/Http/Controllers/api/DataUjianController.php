<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\jawaban;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;


class DataUjianController extends Controller
{
  public function showID ($ujian_id)
  {
    $Soal = Soal::with('jawaban')->where('ujian_id', $ujian_id)->get();

    return new PostResource (true, 'exist', $Soal);
  }

}
