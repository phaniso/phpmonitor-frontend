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
        if(in_array($view, $views)) {
            $this->view($view);
            return;
        }
        $this->view($defaultView);
    }

    private function view($viewName)
    {
        $data = [];
        $this->load->helper('utils_helper');
        $this->load->model('service_model');
        $this->load->model('server_model', 'server');
        $this->load->model('serverHistory_model', 'serverHistory');

        $data['services']       = $this->service_model->getAll();
        $data['serversConfig']  = $this->server->getConfig();
        $data['serversData']    = $this->serverHistory->getServersHistory();
        $data['percents']       = calculatePercentages
        (
            $data['serversData'],
            $data['services']
        );
        $data['updateTime'] = timeSince($this->serverHistory->getLastUpdate());

        $this->viewRender($data, $viewName);
    }
    private function viewRender($data, $viewName)
    {
        $this->load->view('header');
        $viewTemplate = $this->serversList
        (
            $viewName,
            $data['serversData'],
            $data['services'],
            $data['percents']
        );

        $this->load->view(
            'serverList/'.$viewName.'/main',
            [
                'content' => $viewTemplate,
                'updateTime' => $data['updateTime'],
                'services'  => $data['services']
            ]
        );
        $this->load->view('footer');
    }

    private function serversList($viewName, array $servers, $services, $percents)
    {
        $list = '';
        $separator['panel'] = ['opener' => '', 'closer' => ''];
        $separator['table'] = ['opener' => '<td>', 'closer' => '</td>'];
        foreach($servers as $server)
        {
            $listBody = $this->buildServerListBody($viewName, $separator[$viewName], $server, $services, $percents);
            if($server['status'] === 'online') {
            $list .= $this->load->view('serverList/'.$viewName.'/online',
                [
                    'server' => $server,
                    'body' => $listBody
                ],
                true
            );
            } else {
                $list .= $this->load->view('serverList/'.$viewName.'/offline',
                    [
                        'server' => $server,
                        'services' => $services
                    ],
                    true
                );
            }
        }
        return $list;
    }

    private function buildServerListBody($type, $separator, $server, $services, $percents)
    {
        $listContent = '';
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
            if($service['percentages']) {
               $body .= $this->load->view(
                    'serverList/'.$type.'/percentage',
                    [
                        'percents' => $percents[$server['server_id']][$serviceName]
                    ],
                    true
                );
            $body .= $separator['closer'];
            }
            $listContent .= $this->load->view(
                'serverList/'.$type.'/body',
                [
                    'name' => $service['name'],
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
