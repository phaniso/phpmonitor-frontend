<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

    /**
     * Validate password
     * @access public
     * @param $password
     * @return boolean
     */
function passwordValidate($password)
{
    return preg_match(PASSWORD_PATTERN, $password);
}

    /**
     * Validate url
     * @access public
     * @param $url
     * @return boolean
     */
function urlValidate($url)
{
    return preg_match(URL_PATTERN, $url);
}

    /**
     * Validate if variable is domain or ip address
     * @access public
     * @param string
     * @return boolean
     */
function hostnameValidate($hostname)
{
    return (preg_match(IP_PATTERN, $hostname) || preg_match(DOMAIN_PATTERN, $hostname)) ? true : false;
}


/* End of file validator_helper.php */
/* Location: ./application/helper/validator_helper.php */
