<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'dni' => ['required', 'string', 'max:255'],
            'birth' => ['required', 'date'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:255'],
            'mobile_phone' => ['nullable', 'string', 'max:255'],
            'city_dni' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            // 'photo_dni' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            // 'photo_document' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        // if (isset($input['photo_dni'])) {
        //     $file = file('photo_dni');

        //     $nombre = time() . $file->getClientOriginalName();

        //     $ruta = 'photo/' . $user->id . '/' . $nombre;

        //     Storage::disk('public')->put($ruta,  \File::get($file));
        //     $user->photo_dni = $ruta;
        // }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'lastname' => $input['lastname'],
                'email' => $input['email'],
                'dni' => $input['dni'],
                'birth' => $input['birth'],
                'dni_expedition' => $input['dni_expedition'],
                'phone' => $input['phone'],
                'mobile_phone' => $input['mobile_phone'],
                'city_dni' => $input['city_dni'],
                'address' => $input['address'],
                'district' => $input['district'],
                'city' => $input['city'],
                'department' => $input['department'],
            ])->save();
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
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
