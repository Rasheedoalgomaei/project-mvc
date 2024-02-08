<?php

namespace SallaProducts\Database;

use SallaProducts\Database\Concerns\ConnectsTo;
use SallaProducts\Database\Managers\Contracts\DatabaseManager;

class DB
{
    protected DatabaseManager $manager;

    public function __construct(DatabaseManager $manager)
    {
        $this->manager = $manager;
    }


    //Connect  DataBase
    public function init()
    {
        ConnectsTo::connect($this->manager);
    }

    //Execute Query
    public function raw(string $query, $value = [])
    {
        return $this->manager->query($query, $value);
    }

    protected function create(array $data)
    {
        return $this->manager->create($data);
    }

    protected function delete($id)
    {
        return $this->manager->delete($id);
    }

    protected function update($id, array $attributes)
    {
        return $this->manager->update($id, $attributes);
    }

    protected function read($columns = '*', $filter = null)
    {
        return $this->manager->read($columns, $filter);
    }

    public function getLastId() {
        return $this->manager->getLastId();
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $arguments);
        }
    }
}