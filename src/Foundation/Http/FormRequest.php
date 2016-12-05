<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 14:34
 */
namespace Notadd\Foundation\Http;

use Illuminate\Container\Container;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidatesWhenResolvedTrait;
use Illuminate\Validation\ValidationException;

/**
 * Class FormRequest.
 */
class FormRequest extends Request implements ValidatesWhenResolved
{
    use ValidatesWhenResolvedTrait;

    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var \Illuminate\Routing\Redirector
     */
    protected $redirector;

    /**
     * @var string
     */
    protected $redirect;

    /**
     * @var string
     */
    protected $redirectRoute;

    /**
     * @var string
     */
    protected $redirectAction;

    /**
     * @var string
     */
    protected $errorBag = 'default';

    /**
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * TODO: Method getValidatorInstance Description
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $factory = $this->container->make(ValidationFactory::class);
        if (method_exists($this, 'validator')) {
            $validator = $this->container->call([
                $this,
                'validator',
            ], compact('factory'));
        } else {
            $validator = $factory->make($this->validationData(), $this->container->call([
                $this,
                'rules',
            ]), $this->messages(), $this->attributes());
        }
        if (method_exists($this, 'withValidator')) {
            $this->withValidator($validator);
        }

        return $validator;
    }

    /**
     * TODO: Method validationData Description
     *
     * @return array
     */
    protected function validationData()
    {
        return $this->all();
    }

    /**
     * TODO: Method failedValidation Description
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @throws \Illuminate\Validation\ValidationException
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, $this->response($this->formatErrors($validator)));
    }

    /**
     * TODO: Method passesAuthorization Description
     *
     * @return bool
     */
    protected function passesAuthorization()
    {
        if (method_exists($this, 'authorize')) {
            return $this->container->call([
                $this,
                'authorize',
            ]);
        }

        return false;
    }

    /**
     * TODO: Method failedAuthorization Description
     *
     * @throws \Illuminate\Http\Exception\HttpResponseException
     * @return void
     */
    protected function failedAuthorization()
    {
        throw new HttpResponseException($this->forbiddenResponse());
    }

    /**
     * TODO: Method response Description
     *
     * @param array $errors
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        if ($this->expectsJson()) {
            return new JsonResponse($errors, 422);
        }

        return $this->redirector->to($this->getRedirectUrl())->withInput($this->except($this->dontFlash))->withErrors($errors,
            $this->errorBag);
    }

    /**
     * TODO: Method forbiddenResponse Description
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function forbiddenResponse()
    {
        return new Response('Forbidden', 403);
    }

    /**
     * TODO: Method formatErrors Description
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @return array
     */
    protected function formatErrors(Validator $validator)
    {
        return $validator->getMessageBag()->toArray();
    }

    /**
     * TODO: Method getRedirectUrl Description
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        if ($this->redirect) {
            return $url->to($this->redirect);
        } elseif ($this->redirectRoute) {
            return $url->route($this->redirectRoute);
        } elseif ($this->redirectAction) {
            return $url->action($this->redirectAction);
        }

        return $url->previous();
    }

    /**
     * TODO: Method setRedirector Description
     *
     * @param \Illuminate\Routing\Redirector $redirector
     *
     * @return $this
     */
    public function setRedirector(Redirector $redirector)
    {
        $this->redirector = $redirector;

        return $this;
    }

    /**
     * TODO: Method setContainer Description
     *
     * @param \Illuminate\Container\Container $container
     *
     * @return $this
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * TODO: Method messages Description
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * TODO: Method attributes Description
     *
     * @return array
     */
    public function attributes()
    {
        return [];
    }
}
