<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Server_model
 *
 *
 * @package CI
 * @subpackage Model
 */
class Server_model extends CI_Model
{
    private $tableName = 'servers';
    var $name = '';
    var $url_path = '';
    var $ping_hostname = '';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function getConfig($id = null)
    {
        if ($id) {
            $this->db->where('id', $id);
        }
        return $this->db->get($this->tableName);
    }

    public function add($name, $urlPath, $pingHostname)
    {
        $this->name = $name;
        $this->url_path = $urlPath;
        $this->ping_hostname = $pingHostname;
        $this->db->insert($this->tableName, $this);
    }

    public function delete($serverId)
    {
        $this->db->where('id', $serverId);
        $this->db->delete($this->tableName);
    }

    public function isValid($id)
    {
        $query = $this->db->query('SELECT id from servers WHERE id=?', array($id));
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}

/* End of file server_model.php */
/* Location: ./application/models/admin/server_model.php */
