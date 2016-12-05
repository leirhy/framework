<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-12-05 13:51
 */
namespace Notadd\Foundation\Http;

use Illuminate\Http\RedirectResponse as IlluminateRedirectResponse;
use Illuminate\Support\ViewErrorBag;

/**
 * Class RedirectResponse.
 */
class RedirectResponse extends IlluminateRedirectResponse
{
    /**
     * @param \Illuminate\Contracts\Support\MessageProvider|array|string $provider
     * @param string                                                     $key
     *
     * @return $this
     */
    public function withMessages($provider, $key = 'default')
    {
        $value = $this->parseErrors($provider);
        $this->session->flash(
            'messages', $this->session->get('messages', new ViewErrorBag)->put($key, $value)
        );

        return $this;
    }
}
