<?php

namespace App\Actions\Fortify;

use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    use WithFileUploads;
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        // dd($input);
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
            'photo_dni' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'photo_document' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        // if (isset($input['photo_dni'])) {
        //     $file = $input['photo_dni'];
        //     $nombre = time() . $file->getClientOriginalName();
        //     $ruta = 'photo_dni/' . $user->id . '/' . $nombre;
        //     $user->photo_dni = $ruta;
        //     $file->storeAs('photo_dni/'.$user->id, $nombre);
        // }
        
        if (isset($input['photo_dni'])) {
            $file = $input['photo_dni'];
            $nombre = time() . $file->getClientOriginalName();
            $ruta = 'photo_dni/' . $user->id . '/' . $nombre;
            $user->photo_dni = $ruta;
            $file->storeAs('public/photo_dni/'.$user->id, $nombre);
        }
        if (isset($input['photo_document'])) {
            $file = $input['photo_document'];
            $nombre = time() . $file->getClientOriginalName();
            $ruta = 'photo_document/' . $user->id . '/' . $nombre;
            $user->photo_document = $ruta;
            $file->storeAs('public/photo_document/'.$user->id, $nombre);
        }

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
