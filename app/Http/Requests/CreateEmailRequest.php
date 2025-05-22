<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titulo' => 'required|string|max:255',
            'remetente' => 'required|email:rfc,dns',
            'destinatarios' => 'required|string',
            'conteudo' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'titulo.required' => 'O título é obrigatório.',
            'remetente.required' => 'O email do remetente é obrigatório.',
            'remetente.email' => 'O email do remetente deve ser válido.',
            'destinatarios.required' => 'Os destinatários são obrigatórios.',
            'conteudo.required' => 'O conteúdo é obrigatório.',
        ];
    }

    public function prepareForValidation()
    {
        if ($this->destinatarios) {
            $emails = array_map('trim', explode(',', $this->destinatarios));
            $emails = array_filter($emails);
            
            foreach ($emails as $email) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $this->failedValidation(
                        validator([],[])->errors()->add('destinatarios', "Email inválido: {$email}")
                    );
                }
            }
            
            $this->merge([
                'destinatarios_array' => $emails
            ]);
        }
    }
}