<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 14:37
 */
namespace Notadd\Foundation\Validation;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Validation\ValidationException;

/**
 * Class ValidatesRequests.
 */
trait ValidatesRequests
{
    /**
     * @var string
     */
    protected $validatesRequestErrorBag;

    /**
     * TODO: Method validateWith Description
     *
     * @param \Illuminate\Contracts\Validation\Validator|array $validator
     * @param \Illuminate\Http\Request|null                    $request
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateWith($validator, Request $request = null)
    {
        $request = $request ?: app('request');
        if (is_array($validator)) {
            $validator = $this->getValidationFactory()->make($request->all(), $validator);
        }
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
    }

    /**
     * TODO: Method validate Description
     *
     * @param \Illuminate\Http\Request $request
     * @param array                    $rules
     * @param array                    $messages
     * @param array                    $customAttributes
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
    }

    /**
     * TODO: Method validateWithBag Description
     *
     * @param string                   $errorBag
     * @param \Illuminate\Http\Request $request
     * @param array                    $rules
     * @param array                    $messages
     * @param array                    $customAttributes
     *
     * @throws \Illuminate\Validation\ValidationException
     * @return void
     */
    public function validateWithBag(
        $errorBag,
        Request $request,
        array $rules,
        array $messages = [],
        array $customAttributes = []
    ) {
        $this->withErrorBag($errorBag, function () use ($request, $rules, $messages, $customAttributes) {
            $this->validate($request, $rules, $messages, $customAttributes);
        });
    }

    /**
     * TODO: Method throwValidationException Description
     *
     * @param \Illuminate\Http\Request                   $request
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @throws \Illuminate\Validation\ValidationException
     * @return void
     */
    protected function throwValidationException(Request $request, $validator)
    {
        throw new ValidationException($validator,
            $this->buildFailedValidationResponse($request, $this->formatValidationErrors($validator)));
    }

    /**
     * TODO: Method buildFailedValidationResponse Description
     *
     * @param \Illuminate\Http\Request $request
     * @param array                    $errors
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function buildFailedValidationResponse(Request $request, array $errors)
    {
        if ($request->expectsJson()) {
            return new JsonResponse($errors, 422);
        }

        return redirect()->to($this->getRedirectUrl())->withInput($request->input())->withErrors($errors,
            $this->errorBag());
    }

    /**
     * TODO: Method formatValidationErrors Description
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @return array
     */
    protected function formatValidationErrors(Validator $validator)
    {
        return $validator->errors()->getMessages();
    }

    /**
     * TODO: Method getRedirectUrl Description
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        return app(UrlGenerator::class)->previous();
    }

    /**
     * TODO: Method getValidationFactory Description
     *
     * @return \Illuminate\Contracts\Validation\Factory
     */
    protected function getValidationFactory()
    {
        return app(Factory::class);
    }

    /**
     * TODO: Method withErrorBag Description
     *
     * @param string   $errorBag
     * @param callable $callback
     *
     * @return void
     */
    protected function withErrorBag($errorBag, callable $callback)
    {
        $this->validatesRequestErrorBag = $errorBag;
        call_user_func($callback);
        $this->validatesRequestErrorBag = null;
    }

    /**
     * TODO: Method errorBag Description
     *
     * @return string
     */
    protected function errorBag()
    {
        return $this->validatesRequestErrorBag ?: 'default';
    }
}
