<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-12-01 19:58
 */
namespace Notadd\Foundation\Configuration\Writers;

use Exception;

/**
 * Class ConfigWriter.
 */
class ConfigurationWriter
{
    /**
     * TODO: Method toFile Description
     *
     * @param      $filePath
     * @param      $newValues
     * @param bool $useValidation
     *
     * @return mixed|string
     */
    public function toFile($filePath, $newValues, $useValidation = true)
    {
        $contents = file_get_contents($filePath);
        $contents = $this->toContent($contents, $newValues, $useValidation);
        file_put_contents($filePath, $contents);

        return $contents;
    }

    /**
     * TODO: Method toContent Description
     *
     * @param      $contents
     * @param      $newValues
     * @param bool $useValidation
     *
     * @return mixed
     * @throws \Exception
     */
    public function toContent($contents, $newValues, $useValidation = true)
    {
        $contents = $this->parseContent($contents, $newValues);
        if (!$useValidation) {
            return $contents;
        }
        $result = eval('?>' . $contents);
        foreach ($newValues as $key => $expectedValue) {
            $parts = explode('.', $key);
            $array = $result;
            foreach ($parts as $part) {
                if (!is_array($array) || !array_key_exists($part, $array)) {
                    throw new Exception(sprintf('Unable to rewrite key "%s" in config, does it exist?', $key));
                }
                $array = $array[$part];
            }
            $actualValue = $array;
            if ($actualValue != $expectedValue) {
                throw new Exception(sprintf('Unable to rewrite key "%s" in config, rewrite failed', $key));
            }
        }

        return $contents;
    }

    /**
     * TODO: Method parseContent Description
     *
     * @param $contents
     * @param $newValues
     *
     * @return mixed
     */
    protected function parseContent($contents, $newValues)
    {
        $patterns = [];
        $replacements = [];
        foreach ($newValues as $path => $value) {
            $items = explode('.', $path);
            $key = array_pop($items);
            $replaceValue = $this->writeValueToPhp($value);
            $patterns[] = $this->buildStringExpression($key, $items);
            $replacements[] = '${1}${2}' . $replaceValue;
            $patterns[] = $this->buildStringExpression($key, $items, '"');
            $replacements[] = '${1}${2}' . $replaceValue;
            $patterns[] = $this->buildConstantExpression($key, $items);
            $replacements[] = '${1}${2}' . $replaceValue;
            $patterns[] = $this->buildArrayExpression($key, $items);
            $replacements[] = '${1}${2}' . $replaceValue;
        }

        return preg_replace($patterns, $replacements, $contents, 1);
    }

    /**
     * TODO: Method writeValueToPhp Description
     *
     * @param $value
     *
     * @return array|mixed|string
     */
    protected function writeValueToPhp($value)
    {
        if (is_string($value) && strpos($value, "'") === false) {
            $replaceValue = "'" . $value . "'";
        } elseif (is_string($value) && strpos($value, '"') === false) {
            $replaceValue = '"' . $value . '"';
        } elseif (is_bool($value)) {
            $replaceValue = ($value ? 'true' : 'false');
        } elseif (is_null($value)) {
            $replaceValue = 'null';
        } elseif (is_array($value) && count($value) === count($value, COUNT_RECURSIVE)) {
            $replaceValue = $this->writeArrayToPhp($value);
        } else {
            $replaceValue = $value;
        }
        $replaceValue = str_replace('$', '\$', $replaceValue);

        return $replaceValue;
    }

    /**
     * TODO: Method writeArrayToPhp Description
     *
     * @param array $array
     *
     * @return string
     */
    protected function writeArrayToPhp($array)
    {
        $result = [];
        foreach ($array as $value) {
            if (!is_array($value)) {
                $result[] = $this->writeValueToPhp($value);
            }
        }

        return '[' . implode(', ', $result) . ']';
    }

     * TODO: Method buildStringExpression Description
     *
    protected function buildStringExpression($targetKey, $arrayItems = [], $quoteChar = "'")
    {
        $expression = [];
        $expression[] = $this->buildArrayOpeningExpression($arrayItems);
        $expression[] = '([\'|"]' . $targetKey . '[\'|"]\s*=>\s*)[' . $quoteChar . ']';
        $expression[] = '([^' . $quoteChar . ']*)';
        $expression[] = '[' . $quoteChar . ']';
        return '/' . implode('', $expression) . '/';
    }

    /**
     * TODO: Method buildConstantExpression Description
     *
     * @param       $targetKey
     * @param array $arrayItems
     *
     * @return string
     */
    protected function buildConstantExpression($targetKey, $arrayItems = [])
    {
        $expression = [];
        $expression[] = $this->buildArrayOpeningExpression($arrayItems);
        $expression[] = '([\'|"]' . $targetKey . '[\'|"]\s*=>\s*)';
        $expression[] = '([tT][rR][uU][eE]|[fF][aA][lL][sS][eE]|[nN][uU][lL]{2}|[\d]+)';
        return '/' . implode('', $expression) . '/';
    }

    /**
     * TODO: Method buildArrayExpression Description
     *
     * @param       $targetKey
     * @param array $arrayItems
     *
     * @return string
     */
    protected function buildArrayExpression($targetKey, $arrayItems = [])
    {
        $expression = [];
        $expression[] = $this->buildArrayOpeningExpression($arrayItems);
        $expression[] = '([\'|"]' . $targetKey . '[\'|"]\s*=>\s*)';
        $expression[] = '(?:[aA][rR]{2}[aA][yY]\(|[\[])([^\]|)]*)[\]|)]';
        return '/' . implode('', $expression) . '/';
    }

    /**
     * TODO: Method buildArrayOpeningExpression Description
     *
     * @param array $arrayItems
     *
     * @return string
     */
    protected function buildArrayOpeningExpression($arrayItems)
    {
        if (count($arrayItems)) {
            $itemOpen = [];
            foreach ($arrayItems as $item) {
                $itemOpen[] = '[\'|"]' . $item . '[\'|"]\s*=>\s*(?:[aA][rR]{2}[aA][yY]\(|[\[])';
            }
            $result = '(' . implode('[\s\S]*', $itemOpen) . '[\s\S]*?)';
        } else {
            $result = '()';
        }

        return $result;
    }
}
