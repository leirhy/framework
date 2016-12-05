<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-24 18:13
 */
namespace Notadd\Foundation\Member;

use Laravel\Passport\HasApiTokens;
use Notadd\Foundation\Auth\User as Authenticatable;

/**
 * Class Member.
 */
class Member extends Authenticatable
{
    use HasApiTokens;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * TODO: Method findForPassport Description
     *
     * @param $name
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Notadd\Foundation\Member\Member
     */
    public function findForPassport($name)
    {
        return $this->newQuery()->where('name', $name)->first();
    }
}
