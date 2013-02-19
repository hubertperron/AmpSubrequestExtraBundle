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
        $request = $event->getRequest();
        $session = $request->getSession();

        $ignores = $this->container->getParameter('amp_subrequest_extra.ignore_controllers');

        // Using the superglobal because of the order which symfony requests are processed
        if (isset($_REQUEST['_subrequest_extra_enabled'])) {
            $session->set('_subrequest_extra_enabled', (bool) $_REQUEST['_subrequest_extra_enabled']);
        }

        if (false == $session->get('_subrequest_extra_enabled')) {
            return;
        }

        if (Kernel::SUB_REQUEST === $event->getRequestType()) {

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

            $hasParameters = count($parameters);

            // JSON_PRETTY_PRINT is only supported since 5.4
            if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
                $jsonParameters = json_encode($parameters, JSON_PRETTY_PRINT);
            } else {
                $jsonParameters = json_encode($parameters);
            }

            $contentIsEmpty = (0 === strlen(preg_replace('/\s+/', '', $content)));

            $wrappedContent = $this->container->get('templating')->render('AmpSubrequestExtraBundle:Listener:wrapper.html.twig', array(
                'controller' => $controller,
                'hasParameters' => $hasParameters,
                'parameters' => $jsonParameters,
                'content' => $content,
                'contentIsEmpty' => $contentIsEmpty
            ));

            $response->setContent($wrappedContent);
        }

        // Injecting CSS and JS content used by the wrappers
        if (Kernel::MASTER_REQUEST == $event->getRequestType()) {

            $css = $this->container->get('templating')->render('AmpSubrequestExtraBundle:Listener:wrapper_css.html.twig');
            $js = $this->container->get('templating')->render('AmpSubrequestExtraBundle:Listener:wrapper_js.html.twig');

            $response->setContent($response->getContent() . $css . $js);
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