<?php

namespace Amp\SubrequestExtraBundle\Listener;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class ResponseListener
{
    private $container;

    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();

        $ignores = array(
        );

        if (Kernel::SUB_REQUEST == $event->getRequestType()) {

            $content = $response->getContent();
            $parameters = $event->getRequest()->attributes->all();
            $controller = $parameters['_controller'];

            // Removing internal parameters
            foreach (array_keys($parameters) as $key) {
                if (0 === strpos($key, '_')) {
                    unset($parameters[$key]);
                }
            }

            // Skipping ignored controllers
            if (in_array($controller, $ignores)) {
                return;
            }

            $wrappedContent = $this->container->get('templating')->render('AmpSubrequestExtraBundle:Listener:wrapper.html.twig', array(
                'controller' => $controller,
                'parameters' => json_encode($parameters, JSON_PRETTY_PRINT),
                'content' => $content
            ));

            $response->setContent($wrappedContent);
        }
    }

    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function getContainer()
    {
        return $this->container;
    }

}