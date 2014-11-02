<?php
namespace Grout\Cyantree\DoctrineModule\Types;

use Doctrine\DBAL\Connection;

interface ConnectionDetailsInterface
{
    function toConfigurationArray();

    function onConnected(Connection $connection);
}
