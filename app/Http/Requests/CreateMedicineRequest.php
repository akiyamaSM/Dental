<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateMedicineRequest extends Request
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
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|unique:medicines,name'.$this->route('medicine.id')
        ];
    }
}
