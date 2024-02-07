<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterValidation extends FormRequest
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
        $id     = intval($this->route('id'));
        $item   = NULL;
        if($id > 0) {
            $item = User::find($id);
        }
        return [
            'email'                   => 'bail|nullable|email|unique:users,email'.($id > 0 ? ','.$item->id.',id' : ''),
            'first_name'                => 'bail|required|string|min:1|max:255',
            'last_name'                 => 'bail|required|string|min:1|max:255',
            'password'                	=> ($id > 0 ? 'bail|sometimes|confirmed|max:255' : 'bail|required|max:255'),
			'password_confirmation'   => 'bail|required_with:password|same:password|max:255',
        ];
    }
}
