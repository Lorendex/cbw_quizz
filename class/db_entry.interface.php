<?php
/**
 * Created: 31/03/2018 06:04
 */

interface db_entry
{
    /**
     * @param int $id
     * @return db_entry | null
     */
    public static function findByID(int $id);

    /**
     * @return db_entry[] | null
     */
    public static function findAll();

    /**
     * @param string $where
     * @return db_entry[] | null
     */
    public static function find(string $where);

    /**
     * @param $obj
     * @return bool
     */
    public static function update($obj);

    /**
     * @param int $id
     * @return bool
     */
    public static function delete(int $id);

    /**
     * @param $obj
     * @return db_entry
     */
    public static function create($obj);

    /**
     * @param array $data
     * @return db_entry
     */
    public static function fromDB(array $data);
}