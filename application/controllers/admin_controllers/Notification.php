<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Notification
 *
 *
 * @package CI
 * @subpackage Controller
 */
class Notification extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/notification_model', 'notification');
        $this->load->library('form_validation');
        $this->load->helper('form');
    }

    public function index()
    {
        $data = ['itemName' => 'Notification', 'itemPath' => 'notification'];
        $data['items'] = $this->notification->get()->result_array();
        $headerData = array('js' => array('admin/notification.js'));
        $content = $this->load->view('admin/itemListing', $data, true);
        $this->load->view('header', $headerData);
        $this->load->view('admin/header', array('content' => $content));
        $this->load->view('footer');
    }

    public function add()
    {
        $data['submitName'] = 'Add';
        $this->formPrepare();
        if ($this->form_validation->run() === false) {
            $this->load->view('header');
            $content = $this->load->view('admin/notification/form', $data, true);
            $this->load->view('admin/header', array('content' => $content));
            $this->load->view('footer');
        } else {
            $this->notification->add(array(
            'name' => $this->input->post('name'),
            'message' => $this->input->post('message')
            ));
            redirect('admin/notification');
        }
    }

    public function edit($notificationId)
    {
        if (!$this->notification->isValid($notificationId)) {
            redirect('admin/notification');
        }
        $data = $this->notification->get($notificationId)->row_array();
        $data['submitName'] = 'Edit';
        $this->formPrepare();

        if ($this->form_validation->run() === false) {
            $this->load->view('header');
            $content = $this->load->view('admin/notification/form', $data, true);
            $this->load->view('admin/header', array('content' => $content));
            $this->load->view('footer');
        } else {
            $this->notification->edit(array(
            'id' => $notificationId,
            'name' => $this->input->post('name'),
            'message' => $this->input->post('message')
            ));
            redirect('admin/notification');
        }
    }

    public function delete()
    {
        header('Content-Type: application/json');
        $this->form_validation->set_rules('id', 'Id', 'required|numeric');
        if ($this->form_validation->run() === false) {
            return print json_encode(array('error' => 'bad notification id.'));
        }
        
        if ($this->notification->hasTriggers($this->input->post('id'))) {
            return print json_encode(array('error' => 'This notification has attached triggers, before this operation you have to delete them.'));
        }

        $this->notification->delete($this->input->post('id'));
            return print json_encode(array('success' => 'true'));
    }
    

    public function formPrepare()
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('message', 'Message', 'required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
    }
}

/* End of file Notification.php */
/* Location application/controllers/admin_controllers/notification.php */
