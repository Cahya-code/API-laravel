<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Soal;
use App\Models\jawaban;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SoalController extends Controller
{
    public function index() {
      $soalx = Soal::with('jawaban')
      ->get();

      return new PostResource (true, 'all data', $soalx);
    }

    public function show (Soal $soal) {

    return new PostResource(true, 'exist', $soal);
    }

    public function store (Request $request) {
        $validator = Validator::make($request->all(), [
          'soal_text' => 'required',
          'ujian_id' => 'required',
          'pilihan_a' => 'required',
          'pilihan_b' => 'required',
          'pilihan_c' => 'required',
          'pilihan_d' => 'required',
          'nilai_benar' => 'required|in:A,B,C,D',
        ]);

        if($validator->fails()) {
          return response()->json
      (['message'=> 'validasi gagal', 'errors'
      => $validator->errors()], 400);
        }

        DB::beginTransaction();

        try {

            $result = [];




            $nilaiBenar = $request->input('nilai_benar');
            $jawabanBenar = ['A' => 0, 'B'=>0, 'C'=>0, 'D'=>0];
            $jawabanBenar[$nilaiBenar]=1;

            $Soal = Soal::create ([
              'soal_text' => $request->input('soal_text'),
              'ujian_id' => $request->input('ujian_id'),
              'Kunci_jawaban' => $nilaiBenar,
            ]);

            $JawabanA = jawaban::create ([
              'soal_id' => $Soal->id,
              'answer' => 'A. ' . $request->input('pilihan_a'),
              'nilai_benar' => $jawabanBenar['A'],
            ]);
            $JawabanB = jawaban::create([
              'soal_id' => $Soal->id,
              'answer' => 'B. ' . $request->input('pilihan_b'),
              'nilai_benar' => $jawabanBenar['B'],
            ]);
            $JawabanC = jawaban::create ([
              'soal_id' => $Soal->id,
              'answer' => 'C. ' . $request->input('pilihan_c'),
              'nilai_benar' => $jawabanBenar['C'],
            ]);
            $JawabanD = jawaban::create ([
              'soal_id' => $Soal->id,
              'answer' => 'D. ' . $request->input('pilihan_d'),
              'nilai_benar' => $jawabanBenar['D'],
            ]);

            $result[] = [
              'soal' => $Soal,
              'jawaban' => [$JawabanA, $JawabanB, $JawabanC, $JawabanD],
            ];
            DB::commit();
                return new PostResource (true, 'Stored', $result);
        }

        catch (\Exception $e) {
          DB::rollback();
          return response()->json(['message' => 'Gagal', 'error' => $e->getMessage()], 500);
        }
    }

//UPDATE

    public function update (Request $request, Soal $Soal) {

      $validator = Validator::make ($request->all(), [
        'soal_text' => '',
        'pilihan_a' => '',
        'pilihan_b' => '',
        'pilihan_c' => '',
        'pilihan_d' => '',
        'nilai_benar' => '',
      ]);

      if ($validator->fails()) {
        return response()->json($validator->errors(), 433);
      }

      DB::beginTransaction();

      try {


          $pilihanJawaban = ['A', 'B', 'C', 'D'];
          $jawabanBenar = $request->input('nilai_benar');


          $Soal->update([
            'soal_text' => $request->input('soal_text'),

          ]);

          foreach ($pilihanJawaban as $pilihan) {
              $jawaban = $request->input('pilihan_' . strtolower($pilihan));
              $jawabanData = [
                  'answer' => $pilihan . '. ' . $jawaban,
                  'nilai_benar' => ($pilihan == $jawabanBenar) ? true : false,
              ];

              Jawaban::where('soal_id', $Soal->id)
                  ->where('answer', 'like', $pilihan . '.%')
                  ->update($jawabanData);
          }

          $Soal->update([
            'Kunci_jawaban' => $jawabanBenar,
        ]);

        DB::commit();

        return new PostResource (true, 'Update', [
          'Soal' => $Soal,
          'answer' => $Soal->jawaban,
        ]);
      }
      catch (\Exception $e) {
      DB::rollback();
      return response()->json(['message' => 'Gagal', 'error' => $e->getMessage()], 500);
      }

    }

    public function destroy(Soal $soal)
    {
      if (!$soal) {
        return new PostResource(false, 'NO exists'. null);
      }
        jawaban::where('soal_id', $soal->id)->get()->each->delete();
        $soal->delete();

        return new PostResource(true, 'soal dan jawaban dihapus', null);
    }

}
