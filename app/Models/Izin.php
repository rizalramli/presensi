<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Izin extends Model
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
        $sql = "SELECT id,name as nama FROM users";

        $sql = $sql . " ORDER BY name ASC";

        $result = DB::select($sql);

        return $result;
    }

    public static function getData($bulan, $tahun, $guru)
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

        if ($guru != null) {
            $sql .= " AND i.id_user = " . $guru;
        }

        $sql = $sql . " ORDER BY i.tanggal DESC";

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
}
