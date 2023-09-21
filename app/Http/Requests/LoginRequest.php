<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;
use Illuminate\Validation\Factory;
use Illuminate\Http\JsonResponse;
use Zizaco\Entrust\EntrustFacade;
use Zizaco\Entrust\Entrust;

class LoginRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email_address' => ['required','email'],
            'password' => ['required']
        ];
    }
}