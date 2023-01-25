<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\DifferentDate;
use Illuminate\Validation\Rule;
use App\Models\Schedule;

class StoreAndUpdateScheduleRequest extends FormRequest
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

        if ($this->method() == 'POST') {
            return [
                'name' => 'min:3|max:256',
                'cpf' => 'unique:schedules|min:11|max:11',
                'card_sus' => 'unique:schedules|min:15|max:15',
                'reason' => 'required|max:256',
                'date_scheduling' => ['required', new DifferentDate],
                'doctor_name' => 'min:3|max:256',
                'professional_name' => 'min:3|max:256'
            ];
        }

        if ($this->method() == 'PUT') {
            $id = $this->request->get('id');
            $scheduling = Schedule::find($id);
            if(!$scheduling) {
                return [
                  
                ];
            }

            return [
                'name' => 'min:3|max:256',
                'cpf' => ['min:11', 'max:11', Rule::unique('schedules')->ignore($scheduling->cpf, 'cpf')],
                'card_sus' => ['min:15','max:15', Rule::unique('schedules')->ignore($scheduling->card_sus, 'card_sus')],
                'reason' => 'required|max:256',
                'date_scheduling' => ['required', new DifferentDate($id)],
                'doctor_name' => 'min:3|max:256',
                'professional_name' => 'min:3|max:256'
            ];
        }
    }

    /*Costomizando as mensagens de erro*/
    public function messages()
    {
        return [
            'name.min' => 'O nome precisa ter mais de 3 caracteres',
            'name.max' => 'O nome no máximo 256 caracteres',
            'cpf.min' => 'O CPF precisa ter 11 dígitos',
            'cpf.max' => 'O CPF precisa ter 11 dígitos',
            'card_sus.min' => 'O Cartão SUS precisa ter 15 dígitos',
            'card_sus.max' => 'O Cartão SUS precisa ter 15 dígitos',
            'date_scheduling.required' => 'Informe uma data',
            'reason.required' => 'Informe o motivo',
            'doctor_name.min' => 'O nome do médico precisa ter mais de 3 caracteres',
            'doctor_name.max' => 'O nome do médico no máximo 256 caracteres',
            'professional_name.min' => 'O nome do profissional precisa ter mais de 3 caracteres',
            'professional_name.max' => 'O nome do profissional no máximo 256 caracteres',
            'cpf.unique' => 'CPF já cadastrado',
            'card_sus.unique' => 'Cartão SUS já cadastrado',
        ];
    }

}
