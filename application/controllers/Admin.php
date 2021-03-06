<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Admin
 *
 *
 * @package CI
 * @subpackage Controller
 */
class Admin extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('server_model', 'server');
        $this->load->model('user_model', 'user');
        $this->load->helper('validator_helper');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['servers_config'] = $this->server->getConfig()->result_array();
        $headerData =
        [
            'js' => 
            [
                'admin/admin.js'
            ]
        ];
        $this->load->view('header', $headerData);
        $content = $this->load->view('admin/main', $data, true);
        $this->load->view('admin/header', ['content' => $content]);
        $this->load->view('footer');
    }

    public function profile()
    {
        $headerData = 
        [
            'js' => 
            [
                'admin/admin.js'
            ]
        ];
        $this->load->view('header', $headerData);
        $content = $this->load->view('admin/profile', '', true);
        $this->load->view('admin/header', ['content' => $content]);
        $this->load->view('footer');
    }

    public function editProfile()
    {
        header('Content-Type: application/json');

        $this->form_validation->set_rules(
            'password',
            'Password',
            'required|trim|min_length[4]|matches[password_confirmation]'
        );
        $this->form_validation->set_rules(
            'password_confirmation',
            'Password Confirmation',
            'required'
        );
        $username = $this->session->userdata('username');
        $password = hash('sha256', $this->input->post('password') . $username);

        if ($this->form_validation->run() == false) {
            $ret = ['error' => validation_errors(' ', " ")];
        } else {
            $this->user->setPassword($username, $password);
            $ret = ['success' => "Password changed"];
        }
        print json_encode($ret);
    }
}

/* End of file admin.php */
/* Location application/controllers/admin.php */
