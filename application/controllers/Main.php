<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Main
 *
 *
 * @package    CI
 * @subpackage Controller
 */
class Main extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->helper('date');
    }

    public function index()
    {
        $this->load->model('service_model');
        $data = array();
        if (!config_item('installed')) {
            redirect(site_url('install'));
        }
        $this->load->helper('utils_helper');
        $this->load->model('server_model', 'server');
        $this->load->model('serverHistory_model', 'serverHistory');

        $data['services'] = $this->service_model->getAll();
        $data['serversConfig'] = $this->server->getConfig();
        $data['serversData'] = $this->serverHistory->getServersHistory();
        $data['percents'] = calculatePercentages($data['serversData'], $data['services']);
        $data['updateTime'] = timeSince($this->serverHistory->getLastUpdate());
        $this->load->view('header');
        $this->load->view('main', $data);
        $this->load->view('footer');
    }

    public function pageNotFound()
    {
        $this->load->view('errors/html/error_404', array(
            'heading' =>'404',
            'message' => 'Requested Page not Found'
            ));
    }
}

/* End of file main.php */
/* Location application/controllers/main.php */
