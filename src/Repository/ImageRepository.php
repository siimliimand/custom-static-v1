<?php

namespace App\Repository;

use App\DB\DB;

class ImageRepository
{
    public const TABLE_NAME = 'images';

    /**
     * @param string $filename
     * @param string $path
     * @return int|null
     */
    public static function insert(string $filename, string $path): ?int
    {
        $tableName = static::TABLE_NAME;
        $sql = "
        INSERT INTO `$tableName`
        (`filename`, `path`, `created_at`)
        VALUES
        (:filename, :path, NOW())
        ";
        if(DB::execute($sql, [
            'filename' => $filename,
            'path' => $path
        ]) !== null) {
            return DB::getLastInsertId();
        }

        return null;
    }

    /**
     * @param int $id
     * @param string $path
     */
    public static function updatePath(int $id, string $path): void
    {
        $tableName = static::TABLE_NAME;
        DB::execute("
        UPDATE `$tableName`
           SET `path` = :path
         WHERE `id` = :id
        ", [
            'id' => $id,
            'path' => $path
        ]);
    }
}