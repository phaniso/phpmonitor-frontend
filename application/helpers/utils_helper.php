<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Utils_helper
 *
 *
 * @package CI
 * @subpackage Helper
 */

/**
 * Converting Bytes to more readible units
 * @access public
 * @param int $Bytes
 * @return string
 */
function convertUnit($bytes)
{
    $type = array("", "K", "M", "G", "T");
    $index = 0;
    while ($bytes >= 1024) {
        $bytes /= 1024;
        $index++;
    }
    return ("" . round($bytes, 1) . " " . $type[$index] . "b");
}

/**
 * Calculate service percentages
 * @access public
 * @param array $serversData
 * @param array $services
 * @param boolean $retOne
 * @return array
 */
function calculatePercentages(array $serversData, array $services, $retOne = false)
{
    $ret = array();
    foreach ($serversData as $server) {
        foreach ($services as $serviceName => $service) {

            list($column1, $column2) = array_pad(explode(":", $service['dbcolumns']), 2, 1);
                if (is_numeric($column2)) {
                    $server[$column2] = $column2;
                }

                $percent = getPercentage($server[$column1], $server[$column2]);

                $retOne ? $ret[$serviceName] = $percent :$ret[$server['server_id']][$serviceName] = $percent;
        }
    }
    return $ret;
}
/**
 * Get Progress bar class
 *
 * @param int $value
 */
function getProgressBar($value)
{
    if($value >= 85) return 'progress-bar-danger';
    if($value >= 60) return 'progress-bar-warning';

    return 'progress-bar';
}

/**
 * Get what percent is $value1 of $value2
 * @access public
 * @param $value1
 * @param $value2
 * @return double
 */
function getPercentage($value1, $value2)
{
    if ($value2 == 0) {
        return 0;
    }
    $percent = round(($value1 / $value2) * 100, 0);
    if ($percent > 100) {
        return 100;
    }

    return $percent;
}

/**
 * Check if string is Json Object
 * @access public
 * @param string $json_string
 * @return boolean
 */
function isJson($jsonString)
{
    if (gettype($jsonString) != "String") {
        return false;
    }
        
    return is_object(json_decode($jsonString)) ? true : false;
}

/**
 * Time Since function
 * @access public
 * @param int $since
 * @return string
 */
function timeSince($since)
{
    if ($since == 0) {
        return 'Never';
    }
        
    return timespan($since, now()) . ' ago';
}

/**
 * Sanitize data
 * @access public
 * @param array $dataArr
 */
function sanitize(&$dataArr)
{
    foreach ($dataArr as &$data) {
        $data = strip_tags($data);
    }
}

/* End of file utils_helper.php */
/* Location: ./application/helper/utils_helper.php */
