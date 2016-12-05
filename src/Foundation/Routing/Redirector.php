<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-12-05 13:49
 */
namespace Notadd\Foundation\Routing;

use Illuminate\Routing\Redirector as IlluminateRedirector;
use Notadd\Foundation\Http\RedirectResponse;

/**
 * Class Redirector.
 */
class Redirector extends IlluminateRedirector
{
    /**
     * @param string $path
     * @param int    $status
     * @param array  $headers
     *
     * @return \Notadd\Foundation\Http\RedirectResponse
     */
    public function createRedirect($path, $status, $headers)
    {
        $redirect = new RedirectResponse($path, $status, $headers);
        if (isset($this->session)) {
            $redirect->setSession($this->session);
        }
        $redirect->setRequest($this->generator->getRequest());

        return $redirect;
    }
}
