<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreatePaymentRequest extends Request
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
            'versed' => 'required|numeric|valid:'.$this->route('id')
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'versed.valid' => 'Euuuups, You have just put greater than the necessary !!',
        ];
    }
}
