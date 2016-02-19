<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Service_model
 *
 *
 * @package CI
 * @subpackage Model
 */
class Service_model extends CI_Model
{
    private $tableName = 'services';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function getByName($name)
    {
        $this->db->where('name', $name);
        $query = $this->db->get($this->tableName);
        $service = $query->row_array();
        return $service;
    }

    public function getAll()
    {
        $query = $this->db->get($this->tableName);
        $services = $query->result_array();
        return $services;
    }
}
