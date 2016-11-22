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
     * @param \Illuminate\Contracts\Validation\Validator|array $validator
     * @param \Illuminate\Http\Request|null                    $request
     *
     * @return void
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
     * @param \Illuminate\Http\Request $request
     * @param array                    $rules
     * @param array                    $messages
     * @param array                    $customAttributes
     *
     * @return void
     */
    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
    }

    /**
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
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @return array
     */
    protected function formatValidationErrors(Validator $validator)
    {
        return $validator->errors()->getMessages();
    }

    /**
     * @return string
     */
    protected function getRedirectUrl()
    {
        return app(UrlGenerator::class)->previous();
    }

    /**
     * @return \Illuminate\Contracts\Validation\Factory
     */
    protected function getValidationFactory()
    {
        return app(Factory::class);
    }

    /**
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
     * @return string
     */
    protected function errorBag()
    {
        return $this->validatesRequestErrorBag ?: 'default';
    }
}
