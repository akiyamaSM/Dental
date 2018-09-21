<?php

namespace App\Http\Requests;


class PatientRequest extends Request
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
            'firstName' => 'required',
            'lastName'  => 'required',
            'birthDay'  => 'required|date',
            'CIN'       => 'required|unique:patients|max:10',
            'phone'     => 'required|unique:patients',
            'gender'    => 'required',
        ];
    }
}
