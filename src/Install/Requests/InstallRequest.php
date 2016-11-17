<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-24 11:30
 */
namespace Notadd\Install\Requests;

use Notadd\Foundation\Http\FormRequest;

/**
 * Class InstallRequest.
 */
class InstallRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'admin_account.required'   => '必须填写管理员账号',
            'admin_email.required'     => '必须填写管理员邮箱',
            'admin_password.required'  => '必须填写管理员密码',
            'admin_password.confirmed' => '管理员密码验证不正确',
            'website.required'         => '必须填写网站名称',
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'admin_account'  => 'required',
            'admin_email'    => 'required',
            'admin_password' => 'required|confirmed',
            'website'        => 'required',
        ];
    }
}
