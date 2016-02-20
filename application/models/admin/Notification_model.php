<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Notification_model
 *
 *
 * @package CI
 * @subpackage Model
 */
class Notification_model extends CI_Model
{

    private $tableName = 'notifications';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/trigger_model', 'trigger');
    }

    public function isValid($id)
    {
        $query = $this->db->get_where(
            $this->tableName,
            ['id' => $id]
        );
        return $query->num_rows() === 1 ? true : false;
    }

    public function hasTriggers($id)
    {
        $triggersCount = $this->trigger->getByNotificationId($id)->num_rows();
        return $triggersCount > 0 ? true : false;
    }

    public function get($id = null)
    {
        if ($id) {
            $this->db->where('id', $id);
        }
        return $this->db->get($this->tableName);
    }

    public function add($data)
    {
        $this->db->insert($this->tableName, $data);
    }

    public function edit($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update($this->tableName, $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->tableName);
    }

    public function deleteLogsByServerId($serverId)
    {
        $this->db->where('server_id', $serverId);
        $this->db->delete('notification_logs'); 
    }
}

/* End of file Notification_model.php */
/* Location: ./application/models/Notification_model.php */
