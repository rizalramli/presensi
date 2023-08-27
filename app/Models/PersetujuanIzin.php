<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PersetujuanIzin extends Model
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

    public static function getDataGuru()
    {
        $sql = "SELECT u.id,u.name as nama FROM users u
        JOIN model_has_roles mhr ON mhr.model_id = u.id
        JOIN roles r ON r.id = mhr.role_id WHERE r.name != 'Admin' AND is_aktif = 1";

        $sql = $sql . " ORDER BY u.name ASC";

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
            i.status = 0 
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
        $sql = DB::table('izin')
            ->where('id', $request->id)
            ->update([
                'id_user_konfirmasi' => $request->id_user_konfirmasi,
                'tanggal_konfirmasi' => now(),
                'alasan_penolakan' => $request->alasan_penolakan,
                'status' => $request->status,
                'updated_at' => now()
            ]);

        return $sql;
    }
}
