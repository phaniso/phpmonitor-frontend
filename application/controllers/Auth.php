<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Auth
 *
 *
 * @package CI
 * @subpackage Controller
 */
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->helper('form_helper');
    }
    
    public function index()
    {
        !$this->isLoggedIn() ? redirect('auth/login') : redirect('admin');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(site_url('index'));
    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = hash('sha256', $this->input->post('password') . $username);
        if ($username && $password) {
            if ($this->canLogin($username, $password)) {
                $this->registerSession($username);
                redirect('admin');
            } else {
                $this->load->view('auth/login', array(
                'error' => 'Username or Password is incorrect!'));
                return;
            }
        }
        $this->load->view('auth/login');
    }
    
    public function registerSession($username)
    {
        $user = $this->user->getUserByUsername($username);
        $this->session->set_userdata(array(
            'userId'        => $user['id'],
            'username'      => $user['username'],
            'userAccess'    => $user['access'],
            'loggedIn'      => true
            ));
            return true;
    }
    
    public function canLogin($username, $password)
    {
        $user = $this->user->getUserByUsername($username);
        if (!$user) {
            return false;
        }
        return ($user['username'] === $username
                && $user['password'] === $password) ? true : false;
    }
    
    public function hasAccess($level)
    {
        if (!$this->loggedIn()) {
            return false;
        }
        
        return ($this->session->userdata('userAccess') >= $level) ? true : false;
    }

    public function isLoggedIn()
    {
        return $this->session->userdata('loggedIn') ? true : false;
    }
}

/* End of file auth.php */
/* Location application/controllers/auth.php */
