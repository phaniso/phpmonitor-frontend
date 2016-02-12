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

    public function index($view = '')
    {
        $defaultView = 'table';
        $views = ['table', 'panel'];
        if(in_array($view, $views))
            $this->view($view);
        else
            $this->view($defaultView);
    }

    private function view($viewName)
    {
        $data = [];
        $this->load->model('service_model');
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

        $methodName = 'view'.$viewName;
        if(method_exists($this, $methodName)) {
            call_user_func([$this, $methodName], $data);
        }
    }

    private function viewTable($data)
    {
        $this->load->view('header');
        $table = $this->serversTable(
            'table',
            $data['serversData'],
            $data['services'],
            $data['percents']
        );
        $this->load->view(
            'serverList/table/main',
            [
                'tableContent' => $table,
                'updateTime' => $data['updateTime'],
                'services'  => $data['services']
            ]
        );
        $this->load->view('footer');
    }

    private function viewPanel($data)
    {
        $this->load->view('header');
        $panels = $this->serversPanels(
            'panel',
            $data['serversData'],
            $data['services'],
            $data['percents']
        );
        $this->load->view('serverList/panel/main', 
            [
                'panels' => $panels,
                'updateTime' => $data['updateTime']
            ]
        );
        $this->load->view('footer');
    }

    private function serversPanels($type, array $servers, $services, $percents)
    {
        $panels = '';
        $separator = ['opener' => '<div class="col-md-4">', 'closer' => '</div>'];
        foreach($servers as $server)
        {
            $panelBody = $this->buildListBody($type, $separator, $server, $services, $percents);
            if($server['status'] === 'online') {
            $panels .= $this->load->view('serverList/panel/online',
                [
                    'server' => $server,
                    'panelBody' => $panelBody
                ],
                true
            );
            } else {
                $panels .= $this->load->view('serverList/panel/offline',
                    [
                        'server' => $server
                    ],
                    true
                );
            }
        }
        return $panels;
    }

    private function serversTable($type, array $servers, $services, $percents)
    {
        $table = '';
        $separator = ['opener' => '<td>', 'closer' => '</td>'];

        foreach($servers as $server) {
            $tableBody = $this->buildListBody($type, $separator, $server, $services, $percents);
            if($server['status'] == 'online') {
                $table .= $this->load->view(
                    'serverList/table/online',
                    [
                        'server' => $server,
                        'services' => $services,
                        'body' => $tableBody
                    ],
                    true
                );
            } else {
                $table .= $this->load->view(
                    'serverList/table/offline',
                    [
                        'server' => $server,
                        'services' => $services
                    ],
                    true
                );
            }
        }
        return $table;
    }

    private function buildListBody($type, $separator, $server, $services, $percents)
    {
        $listContent = '';
        $body = '';
        foreach($services as $serviceName => $service) {
            list($column1, $column2) = array_pad(explode(":", $service['dbcolumns']), 2, 1);
            if (is_numeric($column2)) {
                $server[$column2] = $column2;
            }
            $body = $separator['opener'];
            $body .= $service['show_numbers'] ?
                ($service['resize'] ?
                    (convertUnit($server[$column1]) . "/" . convertUnit($server[$column2]))
                    : $server[$column1]) 
            : $percents[$server['server_id']][$serviceName] . '%';
            if($type == 'panel') $body .= $separator['closer'];
            if($service['percentages']) {
               $body .= $this->load->view(
                    'serverList/'.$type.'/percentage',
                    [
                        'percents' => $percents[$server['server_id']][$serviceName]
                    ],
                    true
                );
            if($type == 'table') $body .= $separator['closer'];
            }
            $listContent .= $this->load->view(
                'serverList/'.$type.'/body',
                [
                    'name' => $service['sub'],
                    'body' => $body
                ],
                true
            );

        }
        return $listContent;
    }
}

/* End of file main.php */
/* Location application/controllers/main.php */
