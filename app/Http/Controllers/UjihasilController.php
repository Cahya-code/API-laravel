<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;
use App\Models\UjiHasil;

class UjihasilController extends Controller
{
  ///////
    public function store (Request $request) {

        $validator = Validator::make($request->all(),
        [
        'total' => 'array',
        'adduser' => 'required',
        'Nama_ujian' => 'required',
        'Kategori' => 'required',
        'id_user' => 'required'
        ]);

      if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
      }

      $jawabanSoal = $request->input('total');
      $total = array_sum($jawabanSoal);

      $data = Ujihasil::create([
        'total' => $total,
        'adduser' => $request->input('adduser'),
        'Nama_ujian' => $request->input('Nama_ujian'),
        'Kategori' => $request->input('Kategori'),
        'id_user' => $request->input('id_user'),
        // 'adduser' => $reqeust->input('adduser')
      ]);

      return new PostResource (true, 'Stored', $data);
    }

//////
    public function show(Ujihasil $ujihasil) {
      return new PostResource (true, 'exist', $ujihasil);
    }
///////
    public function index() {
      $data = Ujihasil::all();
      return new PostResource (true, 'alldata', $data);

      }

      public function destroy(Ujihasil $ujihasil) {
        $ujihasil->delete();
        return new PostResource (true, 'Deleted', null);
      } //
}
