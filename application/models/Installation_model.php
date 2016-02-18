<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Database_model
 *
 *
 * @package CI
 * @subpackage Model
 */
class Installation_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function database($adminUsername, $adminPassword, $db)
    {
        list($dbHost, $dbUser, $dbPassword, $dbName) = $db;
        try {
            $pdo = new PDO('mysql:host='.$dbHost.';', $dbUser, $dbPassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $pdo->exec("CREATE DATABASE IF NOT EXISTS ".$dbName.' CHARACTER SET utf8 COLLATE utf8_general_ci');
            if (!$sql) {
                throw new Exception('Can\'t Create database');
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
        $pdo->exec("use ".$dbName);

        $pdo->exec("
      CREATE TABLE IF NOT EXISTS `notifications` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(60) NOT NULL,
        `message` text NOT NULL,
        PRIMARY KEY (`id`),
        KEY `id` (`id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
      ");
        $pdo->exec("
      INSERT INTO `notifications` (`id`, `name`, `message`) VALUES
      (1, 'Memory', 'Server memory reached {triggerValue}%'),
      (2, 'Server Status', 'Server: {hostname} is offline');
      ");
        $pdo->exec("
      CREATE TABLE IF NOT EXISTS `notification_logs` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `trigger_id` int(11) DEFAULT NULL,
        `server_id` int(11) NOT NULL,
        `message` text NOT NULL,
        `created` int(11) DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `server_id` (`server_id`),
        KEY `trigger_id` (`trigger_id`),
        KEY `id` (`id`),
        KEY `created` (`created`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
      ");

        $pdo->exec("
      CREATE TABLE IF NOT EXISTS `notification_triggers` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(60) NOT NULL,
        `notification_id` int(11) NOT NULL,
        `value` varchar(11) NOT NULL,
        `operator` varchar(32) NOT NULL,
        `service_name` varchar(64) NOT NULL,
        `type` varchar(64) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `notification_id` (`notification_id`),
        KEY `id` (`id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
      ");
        $pdo->exec("   
        INSERT INTO `notification_triggers` (`id`, `name`, `notification_id`, `value`, `operator`, `service_name`, `type`) VALUES
        (1, 'Memory overload', 1, '90', '>', 'memory', 'service'),
        (2, 'Server Status', 2, 'offline', '=', 'status', 'table struct');
        ");

        $pdo->exec("
          CREATE TABLE IF NOT EXISTS `servers` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(60) NOT NULL,
            `url_path` varchar(120) NOT NULL,
            `ping_hostname` varchar(40) NOT NULL DEFAULT 'google.com',
            PRIMARY KEY (`id`),
            KEY `id` (`id`)
          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;
          ");
        $pdo->exec("
          INSERT INTO `servers` (`id`, `name`, `url_path`, `ping_hostname`) VALUES
          (1, 'Test server', 'http://api.dev/', 'google.com');
          ");
        $pdo->exec("
          CREATE TABLE IF NOT EXISTS `servers_history` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `server_id` int(11) NOT NULL,
            `hostname` varchar(35) DEFAULT NULL,
            `status` varchar(15) DEFAULT NULL,
            `sys_load` float DEFAULT NULL,
            `cpu_cores` int(11) DEFAULT NULL,
            `memory_usage` bigint(15) DEFAULT NULL,
            `memory_total` bigint(15) DEFAULT NULL,
            `memory_free` bigint(15) DEFAULT NULL,
            `disk_free` bigint(15) DEFAULT NULL,
            `disk_total` bigint(15) DEFAULT NULL,
            `disk_usage` bigint(15) DEFAULT NULL,
            `ping` int(11) DEFAULT NULL,
            `mysql_slow_query` int(11) DEFAULT NULL,
            `mysql_query_avg` int(11) DEFAULT NULL,
            `memcache_hits` int(11) DEFAULT NULL,
            `memcache_miss` int(11) DEFAULT NULL,
            `memcache_get` int(11) DEFAULT NULL,
            `memcache_cmd` int(11) DEFAULT NULL,
            `memcache_bytes` int(11) DEFAULT NULL,
            `memcache_max_bytes` int(11) DEFAULT NULL,
            `time` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `id` (`id`),
            KEY `time` (`time`),
            KEY `server_id` (`server_id`)
          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
          ");
            $pdo->exec("
      CREATE TABLE IF NOT EXISTS `users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(40) NOT NULL,
        `password` char(64) NOT NULL,
        `access` int(11) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `id` (`id`),
        KEY `username` (`username`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
      ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `services` (
        `id` int(11) NOT NULL,
          `name` varchar(32) NOT NULL,
          `percentages` tinyint(1) NOT NULL,
          `dbcolumns` varchar(64) NOT NULL,
          `resize` tinyint(1) NOT NULL,
          `show_graph` tinyint(1) NOT NULL,
          `show_numbers` tinyint(1) NOT NULL
        ) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
    ");

    $pdo->exec("
        INSERT INTO `services` (`id`, `name`, `percentages`, `dbcolumns`, `resize`, `show_graph`, `show_numbers`) VALUES
        (1, 'Cpu Load', 1, 'sys_load:cpu_cores', 0, 1, 1),
        (2, 'Used Memory', 1, 'memory_usage:memory_total', 1, 1, 1),
        (3, 'Used Space', 1, 'disk_usage:disk_total', 1, 1, 1),
        (4, 'Mysql QPS', 0, 'mysql_query_avg', 0, 0, 1),
        (5, 'Memcached Memory', 1, 'memcache_bytes:memcache_max_bytes', 1, 0, 1),
        (6, 'Memcached Misses', 1, 'memcache_miss:memcache_get', 0, 0, 0),
        (7, 'Ping', 0, 'ping', 0, 1, 1);
    ");

    $pdo->exec("
        ALTER TABLE `services`
         ADD PRIMARY KEY (`id`);
    ");

    $pdo->exec("
        ALTER TABLE `services`
        MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
    ");

    $pdo->exec("
      ALTER TABLE `notification_logs`
        ADD CONSTRAINT `notification_logs_ibfk_1` FOREIGN KEY (`server_id`) REFERENCES `servers` (`id`),
        ADD CONSTRAINT `notification_logs_ibfk_2` FOREIGN KEY (`trigger_id`) REFERENCES `notification_triggers` (`id`);
      ");

    $pdo->exec("
      ALTER TABLE `notification_triggers`
        ADD CONSTRAINT `notification_triggers_ibfk_1` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`);
        ");
    $pdo->exec("
      ALTER TABLE `servers_history`
        ADD CONSTRAINT `servers_history_ibfk_1` FOREIGN KEY (`server_id`) REFERENCES `servers` (`id`) ON DELETE CASCADE;
      ");

    $pdo->exec("
      INSERT INTO `users` (`username`, `password`, `access`) VALUES
      ('{$adminUsername}', '" . hash('sha256', $adminPassword . $adminUsername) . "', 3);");
            return true;
        }
}
