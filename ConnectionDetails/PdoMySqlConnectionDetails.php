<?php
namespace Grout\Cyantree\DoctrineModule\ConnectionDetails;

use Doctrine\DBAL\Connection;
use Grout\Cyantree\DoctrineModule\Types\ConnectionDetailsInterface;

class PdoMySqlConnectionDetails implements ConnectionDetailsInterface
{
    public $host = '127.0.0.1';
    public $port = 3306;
    public $username;
    public $password;

    public $unixSocket;
    public $charset = 'utf8';
    public $collation = 'utf8_general_ci';

    public $database;

    function toConfigurationArray()
    {
        return array(
            'host' => $this->host,
            'port' => $this->port,
            'user' => $this->username,
            'password' => $this->password,
            'dbname' => $this->database,
            'unix_socket' => $this->unixSocket,
            'charset' => $this->charset,
            'collate' => $this->collation,
            'driver' => 'pdo_mysql'
        );
    }

    function onConnected(Connection $connection)
    {
        if ($this->charset) {
            $connection->exec('SET NAMES `' . $this->charset. '`');
        }
    }
}
