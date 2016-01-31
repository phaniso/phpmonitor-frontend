<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ConfigEnum
{
    const DATABASE = 1;
    const CONFIG = 2;
}

/**
 * Install
 *
 *
 * @package    CI
 * @subpackage Controller
 */
class Install extends CI_Controller
{

    const CONFIG_PATH = APPPATH.'config/config.php';
    const DATABASE_PATH = APPPATH.'config/database.php';
    const AUTOLOAD_PATH = APPPATH.'config/autoload.php';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('encryption');

        if (config_item('installed')) {
            redirect('index');
        }
    }

    public function index()
    {
        $errors = array();
        $this->prepareForm();
        if ($this->form_validation->run() === false) {
            $this->load->view('installation/form');
        } else {
            try {
                $this->alterConfigs(
                    $this->input->post('db_host'),
                    $this->input->post('db_user'),
                    $this->input->post('db_password'),
                    $this->input->post('db_name'),
                );
                $this->load->model('installation_model', 'install');
                $this->install->database(
                    $_POST['username'],
                    $_POST['password'],
                    [
                    $this->input->post('db_host'),
                    $this->input->post('db_user'),
                    $this->input->post('db_password'),
                    $this->input->post('db_name')
                    ]
                );
            } catch (Exception $e) {
                $errors[] = $e->getMessage().PHP_EOL;
                $this->form_validation->set_message('custom_error', $e->getMessage());
                return $this->load->view('installation/form', ['errors' => $errors]);
            }

            if (count($errors) === 0) {
                $this->load->view('installation/success');
            }
        }
    }

    public function prepareForm()
    {
        $this->form_validation->set_rules('db_host', 'Database host', 'trim|required');
        $this->form_validation->set_rules('db_user', 'Database user', 'trim|required');
        $this->form_validation->set_rules('db_password', 'Database password', 'trim|required');
        $this->form_validation->set_rules('db_name', 'Database name', 'trim|required');
        
        $this->form_validation->set_rules('username', 'Admin Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Admin Password', 'trim|required|matches[password_confirmation]');
        $this->form_validation->set_rules('password_confirmation', 'Password Confirmation', 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
    }
    
    private function alterConfigs($dbHost, $dbUser, $dbPassword, $dbName)
    {
        if (!file_exists(self::CONFIG_PATH)) {
            throw new Exception('Can\'t find config file');
        }

        $configData = file_get_contents(self::CONFIG_PATH);
        if (!$configData) {
            throw new Exception('Can\'t find '. self::CONFIG_PATH);
        }
        
        $configDatabase = file_get_contents(self::DATABASE_PATH.'.example');
        if (!$configDatabase) {
            throw new Exception('Can\'t open '.self::DATABASE_PATH.'.example');
        }

        $autoloadConfig = file_get_contents(self::AUTOLOAD_PATH);
        if (!$autoloadConfig) {
            throw new Exception('Can\'t open '.self::AUTOLOAD_PATH);
        }

        $this->configReplace($configDatabase, 'hostname', $dbHost, ConfigEnum::DATABASE);
        $this->configReplace($configDatabase, 'username', $dbUser, ConfigEnum::DATABASE);
        $this->configReplace($configDatabase, 'password', $dbPassword, ConfigEnum::DATABASE);
        $this->configReplace($configDatabase, 'database', $dbName, ConfigEnum::DATABASE);

        $this->configReplace($configData, 'encryption_key', $this->encryption->create_key(16), ConfigEnum::CONFIG);
        $this->configReplace($configData, 'installed', true, ConfigEnum::CONFIG);

        $autoloadConfigReplacement = "['libraries'] = array('session', 'database');";
        $autoloadConfig = preg_replace("/\['libraries']\ = (.*?);/", $autoloadConfigReplacement, $autoloadConfig);
        
        if (! touch(self::DATABASE_PATH)) {
            throw new Exception('Can\'t write to '.self::DATABASE_PATH);
        }
        file_put_contents(self::DATABASE_PATH, $configDatabase);
        
        if (!is_writable(self::CONFIG_PATH)) {
            throw new Exception('Can\'t write to '.self::CONFIG_PATH);
        }
        file_put_contents(self::CONFIG_PATH, $configData);

        if (!is_writable(self::AUTOLOAD_PATH)) {
            throw new Exception('Can\'t write to '.self::AUTOLOAD_PATH);
        }
        file_put_contents(self::AUTOLOAD_PATH, $autoloadConfig);

        return true;
    }

    private function configReplace(&$config, $name, $replacementValue, $configEnum)
    {
        $replacement = "";
    	$replacePattern = "";

        if ($configEnum == ConfigEnum::DATABASE) {
            $replacePattern = "/\'{$name}'\ => '(.*?)',/";
    		$replacement = "'{$name}' => '{$replacementValue}',";
        } elseif ($configEnum == ConfigEnum::CONFIG) {
            if (is_bool($replacementValue) == true) {
                $replacement = "['{$name}'] = {$replacementValue};";
                $replacePattern = "/\['{$name}']\ = (.*?);/";
            } else {
                $replacement = "['{$name}'] = '{$replacementValue}';";
                $replacePattern = "/\['{$name}']\ = '(.*?)';/";
            }
        }
        $config = preg_replace($replacePattern, $replacement, $config);
    }
}
/* End of file install.php */
/* Location application/controllers/install.php */
