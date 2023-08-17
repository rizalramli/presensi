<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Instansi extends Model
{
    use HasFactory;

    public $table = 'instansi';

    public $timestamps = true;

    public $fillable = [
        'nama_sekolah',
        'alamat',
        'logo',
        'latitude',
        'longitude',
        'radius_absensi',
        'toleransi_keterlambatan',
    ];

    public static function getData()
    {
        $sql = "SELECT * FROM instansi";

        $result = DB::selectOne($sql);

        return $result;
    }

    public static function simpanDataLokasi($request)
    {
        $sql = DB::table('instansi')
            ->where('id', $request->id)
            ->update([
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'radius_absensi' => $request->radius_absensi
            ]);

        return $sql;
    }
}
