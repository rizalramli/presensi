<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Absensi extends Model
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

    public static function getDataGuru()
    {
        $sql = "SELECT id,name as nama FROM users";

        $sql = $sql . " ORDER BY name ASC";

        $result = DB::select($sql);

        return $result;
    }

    public static function getData($bulan, $tahun, $guru)
    {
        $sql = "
        SELECT 
            a.id,
            u.name as nama,
            a.tanggal,
            a.jam_masuk,
            a.jam_pulang,
            a.status_absensi,
            a.foto_masuk,
            a.latitude_masuk,
            a.longitude_masuk,
            a.status_lokasi_masuk,
            a.foto_pulang,
            a.latitude_pulang,
            a.longitude_pulang,
            a.status_lokasi_pulang
        FROM absensi a
        JOIN 
            users u ON u.id = a.id_user
        WHERE 
            a.deleted_at IS NULL
        AND 
            MONTH(a.tanggal) = :bulan
        AND 
            YEAR(a.tanggal) = :tahun";

        if ($guru != null) {
            $sql .= " AND a.id_user = " . $guru;
        }

        $sql = $sql . " ORDER BY a.tanggal DESC,u.name ASC";

        $result = DB::select($sql, [
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);

        return $result;
    }

    public static function deleteData($id)
    {
        $sql = DB::table('izin')
            ->where('id', $id)
            ->update([
                'deleted_at' => now()
            ]);

        return $sql;
    }

    public static function getDataAbsensiHariIni($id_user, $tanggal)
    {
        $sql = "
        SELECT 
            a.jam_masuk,
            a.jam_pulang,
            a.tanggal
        FROM absensi a
        WHERE 
            a.deleted_at IS NULL
        AND 
            a.id_user = :id_user
        AND 
            a.tanggal = :tanggal";

        $result = DB::selectOne($sql, [
            'id_user' => $id_user,
            'tanggal' => $tanggal
        ]);

        return $result;
    }
}
