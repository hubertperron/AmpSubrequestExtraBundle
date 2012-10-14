<?php

namespace Amp\SubrequestExtraBundle\Listener;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class ResponseListener
{
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();

        $ignores = array(
            'EgzaktFrontendCoreBundle:Navigation:PageTitle'
        );

        if (Kernel::SUB_REQUEST == $event->getRequestType()) {

            $content = $response->getContent();
            $controller = $event->getRequest()->get('_controller');

            if (in_array($controller, $ignores)) {
                return;
            }

            $content = '
                <div style="border:solid 1px red;min-height:20px;margin:6px 0;z-index:994">
                    <div style="position:absolute;overflow:hidden;padding:2px 5px;opacity:0.9;background-color:#9FF;z-index:995;line-height:16px;font-family:sans-serif;font-size:11px">' . $controller . '</div>'
                    . $content . '
                </div>';
            $response->setContent($content);
        }
    }

}