<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;
class UpdateUsersRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {

        $rules = [
            'username'      => 'required',
            'first_name'    => 'required',
            'last_name'     => 'required',
            'email'         => 'required|email',

        ];

        if (Input::filled('password')) {
             $rules['password'] = 'confirmed|min:6';
        }

        return $rules;

    }
}
