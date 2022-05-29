<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        if ($input["tipo"] == "associado") {
            Validator::make($input, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->passwordRules(),
                'cpf' => ['required', 'cpf'],
                'telefone' => ['required', 'celular_com_ddd'],
                'cep' => ['required', 'formato_cep'],
                'cid' => ['required', 'max:3'],
                'nascimento' => ['required', 'date_format:d/m/Y'],
                'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            ])->validate();
        } else {
            Validator::make($input, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->passwordRules(),
                'cpf' => ['required', 'cpf'],
                'telefone' => ['required', 'celular_com_ddd'],
                'cep' => ['required', 'formato_cep'],
                'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            ])->validate();
        }

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'tipo' => $input["tipo"],
            'sexo' => $input["sexo"],
            'cpf' => $input["cpf"],
            'telefone' => $input["telefone"],
            'cep' => $input["cep"],
            'cid' => $input["tipo"] == "associado" ? $input["cid"] : null,
            'obs' => $input["tipo"] == "associado" ? $input["obs"] : null,
            'nascimento' => $input["tipo"] == "associado" ? $input["nascimento"] : null,
            'escola' =>  $input["tipo"] == "associado" ? $input["escola"] : null,
        ]);
    }
}
