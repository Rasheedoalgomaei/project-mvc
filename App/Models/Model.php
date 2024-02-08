<?php

namespace App\Models;

use SallaProducts\Support\Str;

abstract class Model
{
    protected static $instance;
    protected  $tableName;

    public static function create(array $attributes)
    {
        self::$instance = static::class;

        return app()->db->create($attributes);
    }

    public static function all()
    {
        self::$instance = static::class;

        return app()->db->read();
    }

    public static function delete($id)
    {
        self::$instance = static::class;

        return app()->db->delete($id);
    }

    public static function update($id, array $attributes)
    {
        self::$instance = static::class;

        return app()->db->update($id, $attributes);
    }

    public static function where($filter, $columns = '*')
    {
        self::$instance = static::class;

        
        return app()->db->read($columns, $filter);
    }

    public static function getModel()
    {
        return self::$instance;
    }

    public static function getTableName()
    {
        return Str::lower(Str::plural(class_basename(self::$instance)));
    }
   
     
    

    public static function getLastId() {

        self::$instance = static::class;
        return app()->db->getLastId();
    }
}