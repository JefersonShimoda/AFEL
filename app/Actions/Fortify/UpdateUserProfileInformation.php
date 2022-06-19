<?php

namespace App\Actions\Fortify;

use App\Models\Doenca;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        if (Auth::user()->tipo == "associado") {
            $input["doença"] = self::_validateDoencaArray($input["doença"]);

            Validator::make($input, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
                'telefone' => ['required', 'celular_com_ddd'],
                'cep' => ['required', 'formato_cep'],
                'doença'  => ['required', 'min:1'],
            ])->validateWithBag('updateProfileInformation');
        } else {
            Validator::make($input, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
                'telefone' => ['required', 'celular_com_ddd'],
                'cep' => ['required', 'formato_cep'],
            ])->validateWithBag('updateProfileInformation');
        }

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'telefone' => $input['telefone'],
                'cep' => $input['cep'],
                'obs' => Auth::user()->tipo == "associado" ? $input['obs'] : null,
                'escola' => Auth::user()->tipo == "associado" ? $input['escola'] : null,
            ])->save();
        }

        if (Auth::user()->tipo == "associado") {
            Doenca::where('user_id', Auth::user()->id)->delete();

            foreach ($input["doença"] as $doenca) {
                Doenca::create([
                    "user_id" => Auth::user()->id,
                    "doenca" => $doenca,
                ]);
            }
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'telefone' => $input['telefone'],
            'cep' => $input['cep'],
            'obs' => Auth::user()->tipo == "associado" ? $input['obs'] : null,
            'escola' => Auth::user()->tipo == "associado" ? $input['escola'] : null,
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }

    private static function _validateDoencaArray($doencas)
    {
        $doencaList = [];
        foreach ($doencas as $doenca) {
            $doenca = preg_replace("/[0-9]+h/", '', $doenca);
            if (!empty($doenca)) {
                $doencaList[] = $doenca;
            }
        }

        return $doencaList;
    }
}
