<?php
namespace Grout\Cyantree\DoctrineModule\Types;

class DoctrineConfig
{
    public $useCache = true;
    public $useProxies = true;

    public $entityPaths = array();

    public $logQueries = false;

    public $connectionDetails = array();
    /*
     *  'type' => 'pdo_mysql',
     *  'host' => '127.0.0.1',
     *  'user' => '',
     *  'password' => '',
     *  'name' => '',
     *  'tablePrefix' => 'lp',
     */
}
