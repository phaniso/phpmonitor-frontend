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
class Trigger extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/trigger_model', 'trigger');
        $this->load->library('form_validation');
        $this->load->helper('form');
    }

    public function index()
    {
        $data = ['itemName' => 'Trigger', 'itemPath' => 'trigger'];
        $data['items'] = $this->trigger->get()->result_array();
        $headerData = array('js' => array('admin/trigger.js'));
        $content = $this->load->view('admin/itemListing', $data, true);
        $this->load->view('header', $headerData);
        $this->load->view('admin/header', array('content' => $content));
        $this->load->view('footer');
    }
    
    public function add()
    {
        $data = $this->prepareForm();
        $data['submitName'] = 'Add';
        if ($this->form_validation->run() === false) {
            $content = $this->load->view('admin/trigger/form_add', $data, true);
            $this->load->view('header');
            $this->load->view('admin/header', array('content' => $content));
            $this->load->view('footer');
        } else {
            $triggerData = array(
            'notification_id' => $this->input->post('notification_id'),
            'value' => $this->input->post('value'),
            'operator' => $this->input->post('operator'),
            'name' => $this->input->post('name'),
            'service_name' => $this->input->post('service_name'),
            'type' => $this->input->post('type')
            );
            $this->trigger->add($triggerData);
            redirect('admin/trigger');
        }
    }

    public function edit($triggerId)
    {
        if (!$this->trigger->isValid($triggerId)) {
            redirect('admin/trigger');
        }
        $data = $this->prepareForm();
        $data['trigger'] = $this->trigger->get($triggerId)->row_array();
        $data['submitName'] = 'Edit';
    
        if ($this->form_validation->run() === false) {
            $content = $this->load->view('admin/trigger/form_edit', $data, true);
            $this->load->view('header');
            $this->load->view('admin/header', array('content' => $content));
            $this->load->view('footer');
        } else {
            $triggerData = array(
            'notification_id' => $this->input->post('notification_id'),
            'value' => $this->input->post('value'),
            'operator' => $this->input->post('operator'),
            'name' => $this->input->post('name'),
            'service_name' => $this->input->post('service_name'),
            'type' => $this->input->post('type')
            );
            $this->trigger->edit($triggerId, $triggerData);
            redirect('admin/trigger');
        }
    }
    
    public function delete()
    {
        header('Content-Type: application/json');
        $this->form_validation->set_rules('id', 'Id', 'required|numeric');
        if ($this->form_validation->run() === false) {
            return print json_encode(array('error' => 'bad id'));
        } else {
            $this->trigger->delete($_POST['id']);
            return print json_encode(array('success' => 'true'));
        }
    }
    
    public function prepareForm()
    {
        $data = array();
        $this->load->model('admin/notification_model', 'notification');
        $notifications = $this->notification->get()->result_array();

        foreach ($notifications as $notification) {
            $data['notificationOptions'][$notification['id']] = $notification['id'].' - '.$notification['name'];
        }
        foreach ($this->trigger->getTriggerTypes() as $type) {
            $data['typeOptions'][$type] = $type;
        }
        foreach ($this->trigger->getTriggerOperators() as $operator) {
            $data['operatorOptions'][$operator] = $operator;
        }

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('service_name', 'Service Name', 'required');
        $this->form_validation->set_rules('notification_id', 'Notification id', 'required|numeric|callback_notificationValidate');
        $this->form_validation->set_rules('value', 'Value', 'required');
        $this->form_validation->set_rules('operator', 'Operator', 'required|callback_operatorValidate');
        $this->form_validation->set_rules('type', 'Type', 'required|callback_typeValidate');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        return $data;
    }

    /**
     * Custom Form validation method
     */
    public function notificationValidate($id)
    {
        $this->load->model('admin/notification_model', 'notification');
        if (!$this->notification->isValid($id)) {
            $this->form_validation->set_message('notificationValidate', 'Notification with this id doesn\'t exists');
            return false;
        }
        return true;
    }

    /**
     * Custom Form validation method
     */
    public function typeValidate($type)
    {
        $triggerTypes = $this->trigger->getTriggerTypes();
        if (!is_array($triggerTypes)) {
            $this->form_validation->set_message('typeValidate', 'Trigger array broken, see application/config');
            return false;
        }
        if (!in_array($type, $triggerTypes)) {
            $this->form_validation->set_message('typeValidate', 'Type is invalid');
            return false;
        }
            return true;
    }
    
    /**
     * Custom Form validation method
     */
    public function operatorValidate($operator)
    {
        $triggerOperators = $this->trigger->getTriggerOperators();
        
        if (!is_array($triggerOperators)) {
            $this->form_validation->set_message('operatorValidate', 'Operator array broken, see application/config');
            return false;
        }
        if (!in_array($operator, $triggerOperators)) {
            $this->form_validation->set_message('operatorValidate', 'Operator has invalid value');
            return false;
        }
            return true;
    }
}

/* End of file notification.php */
/* Location application/controllers/admin_controllers/notification.php */
