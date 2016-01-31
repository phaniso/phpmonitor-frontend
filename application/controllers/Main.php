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
        if (!config_item('installed')) {
            redirect(site_url('install'));
        }
    }

    public function index()
    {
        $this->load->model('service_model');
        $data = array();
        $this->load->helper('utils_helper');
        $this->load->model('server_model', 'server');
        $this->load->model('serverHistory_model', 'serverHistory');

        $data['services'] = $this->service_model->getAll();
        $data['serversConfig'] = $this->server->getConfig();
        $data['serversData'] = $this->serverHistory->getServersHistory();
        $data['percents'] = calculatePercentages(
            $data['serversData'],
            $data['services']
        );
        $data['updateTime'] = timeSince($this->serverHistory->getLastUpdate());
        $this->load->view('header');
        $table = $this->serversTable(
            $data['serversData'],
            $data['services'],
            $data['percents']
        );
        $this->load->view(
            'server/table',
            [
                'tableContent' => $table,
                'updateTime' => $data['updateTime']
            ]
        );
        $this->load->view('footer');
    }

    public function pageNotFound()
    {
        $this->load->view('errors/html/error_404', array(
            'heading' =>'404',
            'message' => 'Requested Page not Found'
            ));
    }

    private function serversTable(array $servers, $services, $percents)
    {
        $table = '';
        foreach($servers as $server) {
            if($server['status'] == 'online') {
                $table .= $this->load->view(
                    'server/tr_online',
                    [
                        'server' => $server, 'services' => $services
                    ],
                    true
                );
                $table .= $this->buildServerTd($services, $percents, $server);
                $table .= '</tr>';
            } else
                $table .= $this->load->view(
                    'server/tr_offline',
                    [
                        'server' => $server, 'services' => $services
                    ],
                    true
                );
        }
        return $table;
    }

    private function buildServerTd($services, $percents, $server)
    {
        $tdContent = '';
        foreach($services as $serviceName => $service) {
            $tdContent .= '<td>';
            list($column1, $column2) = array_pad(explode(":", $service['dbcolumns']), 2, 1);
            if (is_numeric($column2)) {
                $server[$column2] = $column2;
            }
            $tdContent .= $service['show_numbers'] ?
                ($service['resize'] ?
                    (convertUnit($server[$column1]) . "/" . convertUnit($server[$column2]))
                    : $server[$column1]) 
            : $percents[$server['server_id']][$serviceName] . '%';
            if($service['percentages']) {
               $tdContent .= $this->load->view(
                    'server/td_percentage',
                    [
                        'percents' => $percents[$server['server_id']][$serviceName]
                    ],
                    true
                );
            }
            $tdContent .= '</td>';

        }
        return $tdContent;
    }
}

/* End of file main.php */
/* Location application/controllers/main.php */
