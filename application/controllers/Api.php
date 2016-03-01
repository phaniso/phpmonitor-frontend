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
     * @param int $id server id
     * @param string $req service key
     */
    public function serverHistory($id = null, $req = null)
    {
        $data = [];
        $req = urldecode($req);
        $this->load->model('server_model', 'server');
        $this->load->model('serverHistory_model', 'serverHistory');
        $this->load->helper('utils_helper');
        $returnPercentage = true;
        $service = $this->service_model->getByName($req);

        if (! isset($service)) {
            return $this->jsonError('Service not found');
        }
        if (! $this->server->isValid($id)) {
            return $this->jsonError('Server is not valid');
        }

        $dbColumns = explode(':', $service['dbcolumns']);
        $dbColumn = reset($dbColumns);
        $returnPercentage = $this->shouldReturnPercentage($service, $req);

        $serverHistory = $this->serverHistory->getServerHistory($id);
        if (count($serverHistory) < 1) {
            return $this->jsonError('Server doesn\'t have any history');
        }

        foreach ($serverHistory as $serverData) {
            $returnPercentage ? $data[] = calculatePercentages(
                [$serverData],
                ['service' => $service],
                true
            ) : $data[]['service'] = $serverData[$dbColumn];
            $data[count($data) - 1]['Date'] = date("Y/m/d H:i:s", $serverData['time']);
        }
        $this->printCSV($req, $service['name'], $data);
    }

    /**
     * Print services available for drawing graphs
     *
     */
    public function graphServices()
    {
        header('Content-Type: application/json');
        $services = $this->service_model->getGraphActive();
        print json_encode($services);
    }
    
    private function shouldReturnPercentage($service, $req)
    {
        if (count(explode(':', $service['dbcolumns'])) < 2
            || ! $service['percentages']
        ) {
            return false;
        }
        return true;
    }

    /**
    * Print encoded error in json
    *
    */
    private function jsonError($error)
    {
        print json_encode(['error' => $error]);
    }

    /**
    * Print data in CSV format
    *
    */
    private function printCSV($key, $serviceName, $data)
    {
        printf("%s, %s \r\n", 'Date', $serviceName);
        foreach ($data as $row) {
            printf("%s,%s\r\n", $row['Date'], $row['service']);
        }
    }
}

/* End of file api.php */
/* Location application/controllers/api.php */
