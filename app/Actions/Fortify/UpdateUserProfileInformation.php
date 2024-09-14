<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;


class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        // Validate the new fields along with existing ones
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'ice' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'patente' => ['required', 'string', 'max:255'],
            'id_fiscale' => ['required', 'string', 'max:255'],
        ])->validateWithBag('updateProfileInformation');

        // If a profile photo is uploaded, update it
        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        // If the email has changed, handle email verification
        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $input);
        } else {
            // Force fill and save the updated fields
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'ice' => $input['ice'],
                'company_name' => $input['company_name'],
                'address' => $input['address'],
                'phone_number' => $input['phone_number'],
                'patente' => $input['patente'],
                'id_fiscale' => $input['id_fiscale'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        // If the user needs to verify the email, clear the email verification timestamp
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
            'ice' => $input['ice'],
            'company_name' => $input['company_name'],
            'address' => $input['address'],
            'phone_number' => $input['phone_number'],
            'patente' => $input['patente'],
            'id_fiscale' => $input['id_fiscale'],
        ])->save();

        // Send email verification notification
        $user->sendEmailVerificationNotification();
    }
}

