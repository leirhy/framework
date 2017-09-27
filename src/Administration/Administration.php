<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-25 17:47
 */
namespace Notadd\Foundation\Administration;

use InvalidArgumentException;
use Notadd\Foundation\Administration\Abstracts\Administrator;
use Notadd\Foundation\Routing\Traits\Helpers;

/**
 * Class Administration.
 */
class Administration
{
    use Helpers;

    /**
     * @var \Notadd\Foundation\Administration\Abstracts\Administrator
     */
    protected $administrator;

    /**
     * Get administrator.
     *
     * @return \Notadd\Foundation\Administration\Abstracts\Administrator
     */
    public function getAdministrator()
    {
        return $this->administrator;
    }

    /**
     * Status of administrator's instance.
     *
     * @return bool
     */
    public function hasAdministrator()
    {
        return is_null($this->administrator) ? false : true;
    }

    /**
     * Set administrator instance.
     *
     * @param \Notadd\Foundation\Administration\Abstracts\Administrator $administrator
     *
     * @throws \InvalidArgumentException
     */
    public function setAdministrator(Administrator $administrator)
    {
        if (is_object($this->administrator)) {
            throw new InvalidArgumentException('Administrator has been Registered!');
        }
        if ($administrator instanceof Administrator) {
            $this->administrator = $administrator;
            $this->administrator->init();
        } else {
            throw new InvalidArgumentException('Administrator must be instanceof ' . Administrator::class . '!');
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function pages()
    {
        $collection = collect();
        $this->module->pages()->each(function ($definition) use ($collection) {
            $collection->push($definition);
        });

        return $collection;
    }
}
