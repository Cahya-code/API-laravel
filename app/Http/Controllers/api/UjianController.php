<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\jawaban;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

class UjianController extends Controller
{
  /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function index() {
      $ujian = Ujian::all();

      return new PostResource (true, 'all data', $ujian);
    }

    public function store(Request $request) {
      $validator = Validator::make($request->all(), [
        'nama_ujian' =>'required',
        'tipe_ujian' => 'required',
        'mapel_id' => 'required',
        'nama_user' => 'required',
        'id_user' => 'required',
        'mapel_name' => 'required'
      ]);

      if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
      }

      $Ujian = Ujian::create([
        'nama_ujian' => $request->input('nama_ujian'),
        'tipe_ujian' => $request->input('tipe_ujian'),
        'mapel_id' => $request->input('mapel_id'),
        'nama_user' => $request->input('nama_user'),
        'id_user' => $request->input('id_user'),
        'mapel_name' => $request->input('mapel_name')
      ]);

      return new PostResource(true, 'Stored', $Ujian);
    }

    public function show(Ujian $ujian) {
      return new PostResource (true, 'Exist', $ujian);
    }

    public function destroy (Ujian $ujian) {

      $SoalIds = $ujian->soal->pluck('id');
      jawaban::whereIn('soal_id', $SoalIds)->delete();

      $ujian->soal()->delete();
      $ujian->delete();
      return new PostResource(true, 'Deleted' , $ujian);
    }

}
