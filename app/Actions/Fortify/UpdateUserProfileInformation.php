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
            'country_id' => ['nullable', 'string', 'max:255'],
            'document_type' => ['nullable', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'photo_dni_front' => ['nullable', 'max:1024'],
            'photo_dni_back' => ['nullable', 'max:1024'],
            'photo_document' => ['nullable', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        // dd($input['photo_dni']);        
        
        if (isset($input['photo_dni_front'])) {
            if(!is_string($input['photo_dni_front'])){
                $file = $input['photo_dni_front'];
                $nombre = time() . $file->getClientOriginalName();
                $ruta = 'photo_dni_front/' . $user->id . '/' . $nombre;
                $user->photo_dni_front = $ruta;
                $file->storeAs('public/photo_dni_front/'.$user->id, $nombre);
            }
        }

        if (isset($input['photo_dni_back'])) {
            if(!is_string($input['photo_dni_back'])){
                $file = $input['photo_dni_back'];
                $nombre = time() . $file->getClientOriginalName();
                $ruta = 'photo_dni_back/' . $user->id . '/' . $nombre;
                $user->photo_dni_back = $ruta;
                $file->storeAs('public/photo_dni_back/'.$user->id, $nombre);
            }
        }

        if (isset($input['photo_document'])) {
            if(!is_string($input['photo_document'])){
                $file = $input['photo_document'];
                $nombre = time() . $file->getClientOriginalName();
                $ruta = 'photo_document/' . $user->id . '/' . $nombre;
                $user->photo_document = $ruta;
                $file->storeAs('public/photo_document/'.$user->id, $nombre);
            }
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
                'country_id' => $input['country_id'],
                'document_type' => $input['document_type'],
                'city_dni' => $input['city_dni'],
                'address' => $input['address'],
                'district' => $input['district'],
                'city' => $input['city'],
                'department' => $input['department'],
            ])->save();
        }

        return route('dashboard');
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
