<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LaporanAbsensi extends Model
{
    use HasFactory;

    public $table = 'absensi';

    public $timestamps = true;

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

        $sql = $sql . " ORDER BY a.tanggal ASC";

        $result = DB::select($sql, [
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);

        return $result;
    }

    public static function getDataCuti($bulan, $tahun, $guru)
    {
        $sql = "
        SELECT 
            c.id,
            jc.nama as jenis_cuti,
            u.name as nama,
            c.dari_tanggal,
            c.sampai_tanggal,
            c.lama_hari,
            c.bukti_foto,
            c.keterangan,
            c.alasan_penolakan,
            c.status
        FROM cuti c
        JOIN 
            jenis_cuti jc ON jc.id = c.id_jenis_cuti
        JOIN 
            users u ON u.id = c.id_user
        WHERE 
            c.deleted_at IS NULL
        AND 
            status = 1
        AND (
            (YEAR(c.dari_tanggal) = :tahun_start AND MONTH(c.dari_tanggal) = :bulan_start) 
            OR 
            (YEAR(c.sampai_tanggal) = :tahun_end AND MONTH(c.sampai_tanggal) = :bulan_end)
            )";

        if ($guru != null) {
            $sql .= " AND c.id_user = " . $guru;
        }

        $sql = $sql . " ORDER BY c.tanggal_pengajuan ASC";

        $result = DB::select($sql, [
            'bulan_start' => $bulan,
            'tahun_start' => $tahun,
            'bulan_end' => $bulan,
            'tahun_end' => $tahun
        ]);

        return $result;
    }

    public static function getDataLiburNormal()
    {
        $sql = "SELECT hari FROM jam_kerja";

        $sql = $sql . " WHERE is_libur = 1";

        $sql = $sql . " ORDER BY id ASC";

        $result = DB::select($sql);

        return $result;
    }

    public static function getDataLiburNasional($bulan, $tahun)
    {

        $sql = "SELECT tanggal,nama FROM hari_libur  
        WHERE 
            is_aktif = 1
        AND 
            MONTH(tanggal) = :bulan
        AND 
            YEAR(tanggal) = :tahun";

        $sql = $sql . " ORDER BY id ASC";

        $result = DB::select($sql, [
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);

        return $result;
    }
}
