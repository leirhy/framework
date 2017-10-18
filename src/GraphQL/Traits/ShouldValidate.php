<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-18 17:46
 */
namespace Notadd\Foundation\GraphQL\Traits;

use Notadd\Foundation\GraphQL\Errors\ValidationError;

/**
 * Class ShouldValidate.
 */
trait ShouldValidate
{
    /**
     * @return array
     */
    protected function rules()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getRules()
    {
        $arguments = func_get_args();
        $rules = call_user_func_array([$this, 'rules'], $arguments);
        $argsRules = [];
        foreach ($this->args() as $name => $arg) {
            if (isset($arg['rules'])) {
                if (is_callable($arg['rules'])) {
                    $argsRules[$name] = call_user_func_array($arg['rules'], $arguments);
                } else {
                    $argsRules[$name] = $arg['rules'];
                }
            }
        }

        return array_merge($rules, $argsRules);
    }

    /**
     * @param $args
     * @param $rules
     *
     * @return mixed
     */
    protected function getValidator($args, $rules)
    {
        return app('validator')->make($args, $rules);
    }

    /**
     * @return \Closure|null
     */
    protected function getResolver()
    {
        $resolver = parent::getResolver();
        if (!$resolver) {
            return null;
        }

        return function () use ($resolver) {
            $arguments = func_get_args();
            $rules = call_user_func_array([$this, 'getRules'], $arguments);
            if (sizeof($rules)) {
                $args = array_get($arguments, 1, []);
                $validator = $this->getValidator($args, $rules);
                if ($validator->fails()) {
                    throw with(new ValidationError('validation'))->setValidator($validator);
                }
            }

            return call_user_func_array($resolver, $arguments);
        };
    }
}
