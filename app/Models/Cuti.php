<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cuti extends Model
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

    public static function getDataGuru()
    {
        $sql = "SELECT u.id,u.name as nama FROM users u
        JOIN model_has_roles mhr ON mhr.model_id = u.id
        JOIN roles r ON r.id = mhr.role_id WHERE r.name != 'Admin' AND is_aktif = 1";

        $sql = $sql . " ORDER BY u.name ASC";

        $result = DB::select($sql);

        return $result;
    }

    public static function getData($bulan, $tahun, $guru)
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

        if ($guru != null) {
            $sql .= " AND c.id_user = " . $guru;
        }

        $sql = $sql . " ORDER BY c.tanggal_pengajuan DESC";

        $result = DB::select($sql, [
            'bulan_start' => $bulan,
            'tahun_start' => $tahun,
            'bulan_end' => $bulan,
            'tahun_end' => $tahun
        ]);

        return $result;
    }

    public static function deleteData($id)
    {
        $sql = DB::table('cuti')
            ->where('id', $id)
            ->update([
                'deleted_at' => now()
            ]);

        return $sql;
    }
}
