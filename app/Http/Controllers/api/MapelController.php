<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

class MapelController extends Controller
{

// Index
    public function index () {
      $mapel = Mapel::all();
      return new PostResource (true, 'All Data', $mapel);
    }

// Store
    public function store (Request $request) {

      $validator = Validator::make($request->all(), [
          'nama' => 'required',
      ]);
      if ($validator->fails())
      {
        return response()->json(['message' => 'store failed', 'errors'
      => $validator->errors()], 400);
      }

      $mapel = Mapel::create([
        'nama' => $request->input('nama')
      ]);
      return new PostResource (true, 'Succes Store', $mapel);
    }

// Show
    public function show (Mapel $mapel) {
      return new PostResource (true, 'Exist', $mapel);
    }

    public function update (Request $reqeust, Mapel $mapel) {
      $validator = Validator::make ($request->all(), [
        'nama' => 'required',
      ]);
      if ($validator->fails()) {
        return response()->json(['message' => 'store failed', 'errors'
      => $validator->errors()], 400);
      }

      $mapel->update ([
        'nama' => $request->input('nama'),
      ]);

      return new PostResource (true, 'Updated', $mapel);
    }

    public function destroy (Mapel $mapel) {
      $mapel->delete();
      return new PostResource (true, 'deleted', null);
    } //
}
