<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Server
 *
 *
 * @package    CI
 * @subpackage Controller
 */
class Server extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->helper('date');
    }

    public function index($id)
    {
        $this->load->model('server_model', 'server');
        $this->load->model('serverHistory_model', 'serverHistory');
        $this->load->helper('utils_helper');
        
        if (!$this->server->isValid($id)) {
            $error = array(
                'heading' => 'Error',
                'message' => 'This server couldn\'t be found.'
            );
            $this->load->view('errors/html/error_server', $error);
            return;
        }

        $data['server'] = $this->server->getConfig($id)->row_array();
        $data['serverHistory'] = $this->serverHistory->getServerHistory($id, false);
        $data['lastTimeOnline'] = timeSince($this->serverHistory->getServerLastTimeOnline($id));

        if (!$data['serverHistory']) {
            $error = array(
                'heading' => 'Error',
                'message' => 'This server dosen\'t have any history, yet.'
            );
            $this->load->view('errors/html/error_server', $error);
            return;
        }
        $headerData = array('js' => array('dygraph-combined.js'));
        $this->load->view('header', $headerData);
        $this->load->view('server', $data);
        $this->load->view('footer');
    }
}

/* End of file server.php */
/* Location application/controllers/server.php */
