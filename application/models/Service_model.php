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

    public function getAll()
    {
        $services = [];
        $query = $this->db->get_where($this->tableName);
        foreach($query->result() as $row) {
            $services[$row->name] =
            [
                'id' => $row->id,
                'name' => $row->name,
                'sub' => $row->sub,
                'percentages' => $row->percentages,
                'dbcolumns' => $row->dbcolumns,
                'resize' => $row->resize,
                'show_graph' => $row->show_graph,
                'show_numbers' => $row->show_numbers
            ];
        }
        return $services;
    }
}
