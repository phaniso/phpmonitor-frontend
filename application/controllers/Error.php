<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Error
 *
 *
 * @package    CI
 * @subpackage Controller
 */
class Error extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function pageNotFound()
    {
        $this->load->view('errors/html/error_404', array(
            'heading' =>'404',
            'message' => 'Requested Page not Found'
            ));
    }
}

/* End of file Error.php */
/* Location application/controllers/Error.php */
