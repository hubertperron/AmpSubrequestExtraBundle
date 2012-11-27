<?php

namespace Amp\SubrequestExtraBundle\Collector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class SubrequestCollector extends DataCollector
{

    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data['enabled'] = $request->getSession()->get('_subrequest_extra_enabled');
    }

    public function getCurrentState()
    {
        return (int) $this->data['enabled'];
    }

    public function getNextState()
    {
        return (int) !$this->data['enabled'];
    }

    public function getName()
    {
        return 'subrequests';
    }
}