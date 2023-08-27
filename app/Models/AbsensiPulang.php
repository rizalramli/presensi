<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AbsensiPulang extends Model
{
    use HasFactory;

    public $table = 'absensi';

    public $timestamps = true;

    public $fillable = [
        'id_user',
        'tanggal',
        'jam_masuk',
        'latitude_masuk',
        'longitude_masuk',
        'foto_masuk',
        'status_lokasi_masuk',
        'jam_pulang',
        'latitude_pulang',
        'longitude_pulang',
        'foto_pulang',
        'status_lokasi_pulang',
        'status_absensi',
    ];

    public static function IsAbsenMasukHariIni($id, $tanggal)
    {
        $sql = "SELECT jam_masuk FROM absensi
            WHERE 
                deleted_at IS NULL
            AND 
                tanggal = :tanggal 
            AND
                id_user = :id";

        $result = DB::selectOne($sql, [
            'tanggal' => $tanggal,
            'id' => $id,
        ]);

        return $result;
    }

    public static function IsAbsenHariIni($id, $tanggal)
    {
        $sql = "SELECT jam_pulang FROM absensi
            WHERE 
                deleted_at IS NULL
            AND 
                jam_pulang IS NOT NULL
            AND 
                tanggal = :tanggal 
            AND
                id_user = :id";

        $result = DB::selectOne($sql, [
            'tanggal' => $tanggal,
            'id' => $id,
        ]);

        return $result;
    }

    public static function IsCutiHariIni($id_user, $tanggal)
    {
        $sql = "
            SELECT 
                jc.nama as jenis_cuti
            FROM cuti c
            JOIN 
                jenis_cuti jc ON jc.id = c.id_jenis_cuti
            JOIN 
                users u ON u.id = c.id_user
            WHERE 
                c.deleted_at IS NULL
            AND 
                c.status = 1
            AND 
                :tanggal BETWEEN c.dari_tanggal AND c.sampai_tanggal
            AND 
                c.id_user = :id_user";

        $result = DB::selectOne($sql, [
            'tanggal' => $tanggal,
            'id_user' => $id_user
        ]);

        return $result;
    }

    public static function isLiburNormal($hari)
    {
        $sql = "SELECT hari FROM jam_kerja WHERE is_libur = 1 AND format_php = :hari";

        $result = DB::selectOne($sql, [
            'hari' => $hari,
        ]);

        return $result;
    }

    public static function IsLiburNasional($tanggal)
    {

        $sql = "SELECT nama FROM hari_libur  
        WHERE 
            is_aktif = 1
        AND 
            tanggal = :tanggal";

        $sql = $sql . " ORDER BY id ASC";

        $result = DB::selectOne($sql, [
            'tanggal' => $tanggal,
        ]);

        return $result;
    }

    public static function simpanData($request)
    {
        $sql = DB::table('absensi')
            ->where('tanggal', $request->tanggal)
            ->where('id_user', $request->id_user)
            ->update([
                'jam_pulang' => date('H:i:s'),
                'latitude_pulang' => $request->latitude_pulang,
                'longitude_pulang' => $request->longitude_pulang,
                'foto_pulang' => $request->foto_pulang,
                'status_lokasi_pulang' => $request->status_lokasi_pulang,
                'updated_at' => now()
            ]);

        return $sql;
    }
}
