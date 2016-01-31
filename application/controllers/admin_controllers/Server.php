<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Server
 *
 *
 * @package CI
 * @subpackage Controller
 */
class Server extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/notification_model', 'notification');
        $this->load->model('serverHistory_model', 'serverHistory');
        $this->load->model('server_model', 'server');
        $this->load->helper('validator_helper');
        $this->load->library('form_validation');
    }

    public function add()
    {
        header('Content-Type: application/json');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('url_path', 'Url path', 'callback_urlValidate');
        $this->form_validation->set_rules('ping_hostname', 'Hostname', 'callback_hostnameValidate');
        $urlPath = $this->input->post('url_path');

        if ($urlPath[strlen($urlPath) - 1] !== '/') {
            $urlPath .= '/';
        }

        if ($this->form_validation->run() == false) {
            return print json_encode(array('error' => validation_errors(' ', " ")));
        } else {
            $this->server->add(
                $this->input->post('name'),
                $urlPath,
                $this->input->post('ping_hostname')
            );
            return print json_encode(array('success' => 'Success.'));
        }

    }

    public function delete()
    {
        $serverId = (int)$this->input->post('server_id');
        if (!$serverId) {
            return;
        }
        $this->serverHistory->deleteByServerId($serverId);
        $this->notification->deleteLogsByServerId($serverId);
        $this->server->delete($serverId);
    }

    public function urlValidate($url)
    {
        if (urlValidate($url)) {
            return true;
        } else {
            $this->form_validation->set_message('urlValidate', 'Your url path have to contain \'http://\' (eg. http://localhost/api/)');
            return false;
        }
    }

    public function hostnameValidate($hostname)
    {
        if (hostnameValidate($hostname)) {
            return true;
        } else {
            $this->form_validation->set_message('hostnameValidate', '%s is not ip nor domain');
            return false;
        }
    }
}

/* End of file server.php */
/* Location application/controllers/admin_controllers/server.php */
