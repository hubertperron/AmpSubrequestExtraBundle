<?php

namespace Amp\SubrequestExtraBundle\Collector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class SubrequestCollector extends DataCollector
{
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = array();
    }

    public function getName()
    {
        return 'subrequests';
    }
}