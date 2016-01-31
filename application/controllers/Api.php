<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Api
 *
 *
 * @package    CI
 * @subpackage Controller
 */
class Api extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('service_model');
    }

    /**
     * Return server history data for Dygraph
     *
     * @param id - server id
     * @param req - service name
     */
    public function serverHistory($id = null, $req = null)
    {
        $data = array();
        $showableItems = $this->service_model->getAll();
        $this->load->model('server_model', 'server');
        $this->load->model('serverHistory_model', 'serverHistory');
        $this->load->helper('utils_helper');
        $returnPercentage = true;

        if (!isset($showableItems[$req])) {
            return $this->jsonError('Service not found');
        }
        if (!$this->server->isValid($id)) {
            return $this->jsonError('Server is not valid');
        }

        $serverHistory = $this->serverHistory->getServerHistory($id);
        if (count($serverHistory) < 1) {
            return $this->jsonError('Server doesn\'t have any history');
        }
        
        if (count(explode(':', $showableItems[$req]['dbcolumns'])) < 2 || !$showableItems[$req]['percentages']) {
            $returnPercentage = false;
        }
        foreach ($serverHistory as $serverData) {
            $returnPercentage ? $data[] = calculatePercentages(array($serverData), $showableItems, true) : $data[][$req] = $serverData[$req];
            $data[count($data) - 1]['Date'] = date("Y/m/d H:i:s", $serverData['time']);
        }
        
        $this->printCSV($req, $data);
    }

    /**
     * print services available for drawing graphs
     *
     */
    public function graphServices()
    {
        header('Content-Type: application/json');
        $items = $this->service_model->getAll();
        $services= array();
        foreach ($items as $key => $value) {
            if ($value['show_graph']) {
                $services[] = array(
                    'name' => $key,
                    'serviceName' => $value['name'],
                    'sub' => $value['sub'],
                    'percentages' => $value['percentages']
                    );
            }
        }
        print json_encode($services);
    }
    
    /**
    * Print encoded error in json
    *
    */
    private function jsonError($error)
    {
        print json_encode(array('error' => $error));
    }

    /**
    * Print data in CSV format
    *
    */
    private function printCSV($req, $data)
    {
        printf("%s, %s \r\n", 'Date', $req);
        foreach ($data as $row) {
            printf("%s,%s\r\n", $row['Date'], $row[$req]);
        }
    }
}

/* End of file api.php */
/* Location application/controllers/api.php */
