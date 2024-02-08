<?php

namespace SallaProducts\Http;

use SallaProducts\Support\Arr;

class Request
{
    public function getMethod(){

        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getPath(){
        $path= $_SERVER['REQUEST_URI'] ?? '/';

        return str_contains($path,"?") ? explode('?', $path)[0] : $path;
    }

    public function getUrl() {
        return $this->server('REQUEST_URI');
    }

    public function all()
    {
        return $_REQUEST;
    }

    public function only($keys)
    {
        return Arr::only($this->all(), $keys);
    }

    public function get($key)
    {
        return Arr::get($this->all(), $key);
    }

    /**
     *  Get POST parameter
     *
     * @param String $key
     * @return string
     */
    public function input(String $key = '') {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        if ($key != '') {
            return isset($request[$key]) ? $this->clean($request[$key]) : null;
        } 

        return ($request);
    }


     /**
     * Clean Data
     *
     * @param $data
     * @return string
     */
    private function clean($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {

                // Delete key
                unset($data[$key]);

                // Set new clean key
                $data[$this->clean($key)] = $this->clean($value);
            }
        } else {
            $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
        }

        return $data;
    }

    public function server(String $key = '') {
        return isset($_SERVER[strtoupper($key)]) ? $this->clean($_SERVER[strtoupper($key)]) : $this->clean($_SERVER);
    }
    
}
