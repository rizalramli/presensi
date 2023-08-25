<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JenisCuti extends Model
{
    use HasFactory;

    public $table = 'jenis_cuti';

    public $timestamps = true;

    public $fillable = [
        'nama',
        'is_aktif'
    ];

    public static function getData()
    {
        $sql = "SELECT id,nama,is_aktif FROM jenis_cuti";

        $sql = $sql . " WHERE deleted_at IS NULL";

        $sql = $sql . " ORDER BY id ASC";

        $result = DB::select($sql);

        return $result;
    }

    public static function simpanData($request)
    {
        if (empty($request->id)) {
            // Insert Data
            $sql = DB::table('jenis_cuti')->insert([
                'nama' => $request->nama,
                'is_aktif' => $request->is_aktif,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } else {
            // Update Data
            $sql = DB::table('jenis_cuti')
                ->where('id', $request->id)
                ->update([
                    'nama' => $request->nama,
                    'is_aktif' => $request->is_aktif,
                    'updated_at' => now()
                ]);
        }

        return $sql;
    }

    public static function editData($id)
    {
        $sql = "SELECT id,nama,is_aktif FROM jenis_cuti
        WHERE id = :id";

        $result = DB::selectOne($sql, [
            'id' => $id,
        ]);

        return $result;
    }

    public static function updateData($request, $id)
    {
        $sql = DB::table('jenis_cuti')
            ->where('id', $id)
            ->update([
                'is_aktif' => $request->is_aktif,
                'updated_at' => now()
            ]);

        return $sql;
    }

    public static function deleteData($id)
    {
        $sql = DB::table('jenis_cuti')
            ->where('id', $id)
            ->update([
                'is_aktif' => 0,
                'deleted_at' => now()
            ]);

        return $sql;
    }
}
