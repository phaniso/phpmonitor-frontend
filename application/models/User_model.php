<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * User_model
 *
 *
 * @package CI
 * @subpackage Model
 */
class User_model extends CI_Model
{
    private $tableName = 'users';
    //var $id = -1;
    //var $password = '';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function getUserByUsername($username)
    {
        $user = $this->db->get_where(
            $this->tableName,
            ['username' => $username]
        );
        return $user->row_array();
    }
    
    public function setPassword($username, $password)
    {
        $user = $this->getUserByUsername($username);
        if (!$user) {
            return false;
        }
        $this->db->where('id', $user['id']);
        $this->db->update(
            $this->tableName,
            ['password' => $password]
        );
        return true;
    }
}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */
