<?php

namespace SallaProducts\Database\Grammars;

use App\Models\Model;

class MySQLGrammar
{
    public static function buildInsertQuery($keys)
    {
        $values = '';

        $table_name='';

       

        if(Model::getTableName() == 'products'){
            
            $table_name = 'salla_'. Model::getTableName();
            for ($i = 0; $i < count($keys); $i++) {
                $values .= '?, ';
            }
            
           // if(Model::getTableName()){}
    
    
            $query = 'INSERT INTO ' .$table_name . ' (`' . implode('`, `', $keys) . '`) VALUES(' . rtrim($values, ', ') . ')';
    

        }else{
        for ($i = 0; $i < count($keys); $i++) {
            $values .= '?, ';
        }
        

        
        $query = 'INSERT INTO ' .env('DB_PREFIX') . Model::getTableName() . ' (`' . implode('`, `', $keys) . '`) VALUES(' . rtrim($values, ', ') . ')';
        }
       // echo $query ."\n";
        return $query;
    }

    public static function buildUpdateQuery($keys)
    {

        $table_name='';

        if(Model::getTableName() == 'products'){
            
            $table_name = 'salla_'. Model::getTableName();


        $query = 'UPDATE ' .$table_name . ' SET ';

       

        foreach ($keys as $key) {
            $query .= "{$key} = ?, ";
        }

        $query = rtrim($query, ', ') . ' WHERE ID = ?';
    }else{

    $table_name = 'salla_'. Model::getTableName();


    $query = 'UPDATE ' .env('DB_PREFIX') . Model::getTableName() . ' SET ';

    

    foreach ($keys as $key) {
        $query .= "{$key} = ?, ";
    }

    $query = rtrim($query, ', ') . ' WHERE ID = ?';
}



        return $query;
    }

    public static function buildSelectQuery($columns = '*', $filter = null)
    {
        $table_name='';

        if(Model::getTableName() == 'products'){
            
            $table_name = 'salla_'. Model::getTableName();
            if (is_array($columns)) {
                $columns = implode(', ', $columns);
            }
    
           
            $query = "SELECT {$columns} FROM " . $table_name;
    
            if ($filter) {
                $query .= " WHERE {$filter[0]} {$filter[1]} ?";
            }
        }else{
            if (is_array($columns)) {
                $columns = implode(', ', $columns);
            }
    
            $query = "SELECT {$columns} FROM " .env('DB_PREFIX'). Model::getTableName();
    
            if ($filter) {
                $query .= " WHERE {$filter[0]} {$filter[1]} ?";
            }
        }


    
       
     
        return $query;
    }



//     public static function buildSelectQuery($columns = '*', $filter = null)
// {
//     $table_name = '';

//     if (Model::getTableName() == 'products') {
//         $table_name = 'salla_' . Model::getTableName();
//     } else {
//         $table_name = env('DB_PREFIX') . Model::getTableName();
//     }

//     if (is_array($columns)) {
//         $columns = implode(', ', $columns);
//     }

//     $query = "SELECT {$columns} FROM {$table_name}";

//     if ($filter) {
//         $conditions = [];
//         $values = [];

//         foreach ($filter as $column => $condition) {
//             $operator = $condition['operator'];
//             $value = $condition['value'];
//             $conditions[] = "{$column} {$operator} ?";
//             $values[] = $value;
//         }

//         $query .= " WHERE " . implode(' AND ', $conditions);
//     }

//     return [$query, $values];
// }

    public static function buildDeleteQuery()
    {
        $table_name='';

        if(Model::getTableName() == 'products'){
            
            $table_name = 'salla_'. Model::getTableName();
            return 'DELETE FROM ' .$table_name . ' WHERE ID = ?';
        }else{
        return 'DELETE FROM ' .env('DB_PREFIX'). Model::getTableName() . ' WHERE ID = ?';
        }
    }
}