<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HariLibur extends Model
{
    use HasFactory;

    public $table = 'hari_libur';

    public $timestamps = true;

    public $fillable = [
        'tanggal',
        'nama',
        'is_aktif'
    ];

    public static function getData()
    {
        $sql = "SELECT id,tanggal,nama,is_aktif FROM hari_libur";

        $sql = $sql . " WHERE deleted_at IS NULL";

        $sql = $sql . " ORDER BY id ASC";

        $result = DB::select($sql);

        return $result;
    }

    public static function simpanData($request)
    {
        if (empty($request->id)) {
            // Insert Data
            $sql = DB::table('hari_libur')->insert([
                'tanggal' => $request->tanggal,
                'nama' => $request->nama,
                'is_aktif' => $request->is_aktif,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } else {
            // Update Data
            $sql = DB::table('hari_libur')
                ->where('id', $request->id)
                ->update([
                    'tanggal' => $request->tanggal,
                    'nama' => $request->nama,
                    'is_aktif' => $request->is_aktif,
                    'updated_at' => now()
                ]);
        }

        return $sql;
    }

    public static function editData($id)
    {
        $sql = "SELECT id,tanggal,nama,is_aktif FROM hari_libur
        WHERE id = :id";

        $result = DB::selectOne($sql, [
            'id' => $id,
        ]);

        return $result;
    }

    public static function updateData($request, $id)
    {
        $sql = DB::table('hari_libur')
            ->where('id', $id)
            ->update([
                'is_aktif' => $request->is_aktif,
                'updated_at' => now()
            ]);

        return $sql;
    }

    public static function deleteData($id)
    {
        $sql = DB::table('hari_libur')
            ->where('id', $id)
            ->update([
                'deleted_at' => now()
            ]);

        return $sql;
    }
}
