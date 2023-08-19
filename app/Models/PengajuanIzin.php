<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PengajuanIzin extends Model
{
    use HasFactory;

    public $table = 'izin';

    public $timestamps = true;

    public $fillable = [
        'id_jenis_izin',
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

    public static function getDataJenisIzin()
    {
        $sql = "SELECT id,nama FROM jenis_izin WHERE is_aktif = 1 AND deleted_at IS NULL";

        $sql = $sql . " ORDER BY id ASC";

        $result = DB::select($sql);

        return $result;
    }

    public static function getData($bulan, $tahun, $id_user)
    {
        $sql = "
        SELECT 
            i.id,
            ji.nama as jenis_izin,
            u.name as nama,
            i.tanggal,
            i.dari_jam,
            i.sampai_jam,
            i.bukti_foto,
            i.keterangan,
            i.alasan_penolakan,
            i.status
        FROM izin i
        JOIN 
            jenis_izin ji ON ji.id = i.id_jenis_izin
        JOIN 
            users u ON u.id = i.id_user
        WHERE 
            i.deleted_at IS NULL
        AND 
            MONTH(i.tanggal) = :bulan
        AND 
            YEAR(i.tanggal) = :tahun";

        if ($id_user != null) {
            $sql .= " AND i.id_user = " . $id_user;
        }

        $sql = $sql . " ORDER BY i.tanggal DESC,i.id DESC";

        $result = DB::select($sql, [
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);

        return $result;
    }

    public static function simpanData($request)
    {
        $sql = DB::table('izin')->insert([
            'id_jenis_izin' => $request->id_jenis_izin,
            'id_user' => $request->id_user,
            'tanggal' => $request->tanggal,
            'dari_jam' => $request->dari_jam,
            'sampai_jam' => $request->sampai_jam,
            'bukti_foto' => $request->bukti_foto,
            'keterangan' => $request->keterangan,
            'status' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return $sql;
    }
}
