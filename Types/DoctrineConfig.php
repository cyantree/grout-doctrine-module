<?php
namespace Grout\Cyantree\DoctrineModule\Types;

class DoctrineConfig
{
    public $useCache = true;
    public $useProxies = true;

    public $entityPaths = array();

    public $logQueries = false;

    /** @var ConnectionDetailsInterface */
    public $connectionDetails;
}
