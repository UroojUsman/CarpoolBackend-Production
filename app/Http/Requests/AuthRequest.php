<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
            'name'=>['required','string'],
            'phone'=>['required','unique:users','min:13'],
            'email'=>['required','email','string','unique:users'],
            'password'=>['required','string','confirmed']
        ];
    }

    public function store()
    {
        return User::create($this->validated());
    }
}
