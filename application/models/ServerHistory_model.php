<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * ServerHistory_model
 *
 *
 * @package CI
 * @subpackage Model
 */
class ServerHistory_model extends CI_Model
{

    private $tableName = 'servers_history';
    var $name = '';
    var $url_path = '';
    var $ping_hostname = '';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Server_model');
    }

    /**
     * Get last update timestamp
     * @access public
     * @return int
     */
    public function getLastUpdate()
    {
        $query = $this->db->query('SELECT time from servers_history ORDER BY time DESC LIMIT 1');
        if ($query->num_rows() > 0) {
            return $query->row()->time;
        }
        return 0;
    }

    /**
     * Get server history
     * @access public
     * @param id
     * @return array
     */
    public function getServerHistory($id, $status = true, $time = null)
    {
        if ($time === null) {
            $time = time() - 24 * 3600;
        }

        if (! $status) {
            $query = 'SELECT * from servers_history WHERE server_id=? ORDER BY time DESC LIMIT 1';
            return $this->db->query($query, [$id])->row_array();
        }
        $query  = 'SELECT * from servers_history';
        $query .= ' WHERE server_id=?';
        $query .= ' AND status="online" AND time > ?';
        $query .= ' ORDER BY time DESC';
        return $this->db->query($query,[$id,$time])->result_array();
    }

    /**
     * Get last servers history
     * @access public
     * @return array
     */
    public function getServersHistory()
    {
        $serverCount = $this->Server_model->count();
        $this->db->order_by('id', 'desc');
        $this->db->limit($serverCount);
        $query= $this->db->get($this->tableName);
        return $query->result_array();
    }

    /**
     * Return last time server seen online
     * @param id
     * @return int
     */
    public function getServerLastTimeOnline($id)
    {
        $query = $this->db->query(
            "SELECT time FROM servers_history WHERE status='online' AND server_id=? ORDER BY time DESC",
            [$id]
        );
        if ($query->num_rows() > 0) {
            return $query->row()->time;
        }
        return 0;
    }

    public function deleteByServerId($serverId)
    {
        $this->db->where('server_id', $serverId);
        $this->db->delete($this->tableName);
    }
}

/* End of file serverHistory_model.php */
/* Location: ./application/models/serverHistory_model.php */
