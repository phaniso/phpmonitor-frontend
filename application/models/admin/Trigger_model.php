<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Trigger_model
 *
 *
 * @package CI
 * @subpackage Model
 */
class Trigger_model extends CI_Model
{

    private $tableName = 'notification_triggers';
    private $triggerTypes = ['service', 'table struct'];
    private $triggerOperators = ['>', '<', '='];

    public function __construct()
    {
        parent::__construct();
    }
    
    public function getTriggerTypes()
    {
        return $this->triggerTypes;
    }
    
    public function getTriggerOperators()
    {
        return $this->triggerOperators;
    }
    
    public function isValid($id)
    {
        $query = $this->db->get_where($this->tableName, ['id' => $id]);
        return $query->num_rows() === 1 ? true : false;
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

    public function edit($id, $triggerData)
    {
        $this->db->where('id', $id);
        $this->db->update($this->tableName, $triggerData);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->tableName);
    }

    public function getByNotificationId($id)
    {
        return $this->db->get_where(
            $this->tableName,
            [
                'notification_id' => $id
            ]
        );
    }
}

/* End of file trigger_model.php */
/* Location: ./application/models/trigger_model.php */
