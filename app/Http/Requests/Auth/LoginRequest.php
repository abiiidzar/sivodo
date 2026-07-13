<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $loginValue = $this->input('username') ?? $this->input('email');
        $password = $this->input('password');

        $attempts = [];

        if ($loginValue !== null) {
            $attempts[] = ['email' => $loginValue, 'password' => $password];
            $attempts[] = ['username' => $loginValue, 'password' => $password];
        }

        foreach ($attempts as $credentials) {
            if (Auth::attempt($credentials, $this->boolean('remember'))) {
                RateLimiter::clear($this->throttleKey());

                return;
            }
        }

        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'username' => trans('auth.failed'),
        ]);
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'username' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function prepareForValidation()
    {
        $loginValue = $this->input('username') ?? $this->input('email');

        $this->merge([
            'username' => $loginValue,
            'email' => $loginValue,
        ]);
    }

    public function throttleKey(): string
    {
        $loginValue = (string) ($this->input('username') ?? $this->input('email') ?? '');

        return Str::transliterate(Str::lower($loginValue) . '|' . $this->ip());
    }
}
