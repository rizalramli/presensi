<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JamKerja extends Model
{
    use HasFactory;

    public $table = 'jam_kerja';

    public $timestamps = true;

    public $fillable = [
        'hari',
        'format_php',
        'jam_masuk',
        'jam_pulang',
        'is_libur',
    ];

    public static function getData()
    {
        $sql = "SELECT * FROM jam_kerja ORDER BY id ASC";

        $result = DB::select($sql);

        return $result;
    }

    public static function simpanData($request)
    {
        $instansi = DB::table('instansi')
            ->where('id', 1)
            ->update([
                'toleransi_keterlambatan' => $request->toleransi_keterlambatan,
            ]);

        $id = $request->id;
        $jam_masuk = $request->jam_masuk;
        $jam_pulang = $request->jam_pulang;

        foreach ($id as $key => $value) {
            DB::table('jam_kerja')
                ->where('id', $value)
                ->update([
                    'jam_masuk' => $jam_masuk[$key],
                    'jam_pulang' => $jam_pulang[$key],
                    'is_libur' => ($jam_masuk[$key] == null && $jam_pulang[$key] == null ? 1 : 0)
                ]);
        }


        return $instansi;
    }
}
