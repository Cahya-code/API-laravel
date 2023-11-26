<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\jawaban;
use App\Models\Soal;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class JawabanController extends Controller
{
  public function show (jawaban $jawaban) {
    // $jawaban = jawaban::where('soal_id', $soalid)->get(['answer']);
    return new PostResource (true, 'Exist', $jawaban);
  }

public function index(){
  $jawaban = jawaban::all();
  return new PostResource (true, 'alldata', $jawaban);
}
}
