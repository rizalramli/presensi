<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PengajuanCuti extends Model
{
    use HasFactory;

    public $table = 'cuti';

    public $timestamps = true;

    public $fillable = [
        'id_jenis_cuti',
        'id_user',
        'id_user_konfirmasi',
        'tanggal',
        'dari_jam',
        'sampai_jam',
        'bukti_foto',
        'keterangan',
        'tanggal_konfirmasi',
        'alasan_penolakan',
        'status'
    ];

    public static function getDataJenisCuti()
    {
        $sql = "SELECT id,nama FROM jenis_cuti WHERE is_aktif = 1 AND deleted_at IS NULL";

        $sql = $sql . " ORDER BY id ASC";

        $result = DB::select($sql);

        return $result;
    }

    public static function getData($bulan, $tahun, $id_user)
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
        AND (
            (YEAR(c.dari_tanggal) = :tahun_start AND MONTH(c.dari_tanggal) = :bulan_start) 
            OR 
            (YEAR(c.sampai_tanggal) = :tahun_end AND MONTH(c.sampai_tanggal) = :bulan_end)
            )";

        if ($id_user != null) {
            $sql .= " AND c.id_user = " . $id_user;
        }

        $sql = $sql . " ORDER BY c.tanggal_pengajuan DESC,c.id DESC";

        $result = DB::select($sql, [
            'bulan_start' => $bulan,
            'tahun_start' => $tahun,
            'bulan_end' => $bulan,
            'tahun_end' => $tahun
        ]);

        return $result;
    }

    public static function simpanData($request)
    {
        $date1 = strtotime($request->dari_tanggal);
        $date2 = strtotime($request->sampai_tanggal);

        $diffInSeconds = abs($date2 - $date1);
        $lama_hari = floor($diffInSeconds / (60 * 60 * 24));

        $sql = DB::table('cuti')->insert([
            'id_jenis_cuti' => $request->id_jenis_cuti,
            'id_user' => $request->id_user,
            'tanggal_pengajuan' => now(),
            'dari_tanggal' => $request->dari_tanggal,
            'sampai_tanggal' => $request->sampai_tanggal,
            'lama_hari' => $lama_hari + 1,
            'bukti_foto' => $request->bukti_foto,
            'keterangan' => $request->keterangan,
            'status' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return $sql;
    }
}
