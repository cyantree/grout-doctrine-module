<?php
namespace Grout\Cyantree\DoctrineModule;

use Cyantree\Grout\App\App;
use Doctrine\DBAL\Logging\SQLLogger;

class DoctrineLogger implements SQLLogger
{
    /** @var \Cyantree\Grout\App\App */
    private $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }
    public function startQuery($sql, array $params = null, array $types = null)
    {
        $this->app->events->trigger('log', $sql);

//        if ($params) {
//            var_dump($params);
//        }

//        if ($types) {
//            var_dump($types);
//        }
    }

    public function stopQuery()
    {

    }
}
