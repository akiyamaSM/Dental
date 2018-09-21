<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateAppointmentRequest extends Request
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
            'patient_id' => 'required|exists:patients,id|is_available:'.$this->route('appointment.id'),
            'appointment_at' => 'required|date|is_not_in_the_past|is_doctor_available:'.$this->route('appointment.id'),
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'patient_id.is_available' => 'Er, the patient should come to his planed appointment first!!',
            'appointment_at.is_not_in_the_past' => 'Uuuups, Do you want to come back to the past?',
            'appointment_at.is_doctor_available' => 'Sorry, The Doctor need at least 15 between two appointments',
        ];
    }
}
