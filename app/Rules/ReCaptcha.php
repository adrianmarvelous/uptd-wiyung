<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class ReCaptcha implements ValidationRule
{
    /**
     * Validate that the given reCAPTCHA response is accepted by Google.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secret = config('services.recaptcha.secret_key');

        // reCAPTCHA tidak aktif bila secret key belum diisi (mis. di lingkungan lokal).
        if (blank($secret)) {
            return;
        }

        // Nilai kosong ditangani aturan "required" pada LoginRequest supaya
        // pesannya hanya muncul sekali.
        if (blank($value) || ! is_string($value)) {
            return;
        }

        try {
            $response = Http::asForm()
                ->timeout(10)
                ->post(config('services.recaptcha.verify_url'), [
                    'secret' => $secret,
                    'response' => $value,
                    'remoteip' => request()->ip(),
                ]);
        } catch (Throwable $e) {
            // Gagal menghubungi Google: tolak login (fail closed) tetapi catat penyebabnya.
            Log::warning('Verifikasi reCAPTCHA tidak dapat dihubungi.', [
                'error' => $e->getMessage(),
            ]);

            $fail('Verifikasi keamanan sedang tidak dapat diakses. Silakan coba beberapa saat lagi.');

            return;
        }

        if (! $response->successful()) {
            Log::warning('Verifikasi reCAPTCHA mengembalikan status tidak sukses.', [
                'status' => $response->status(),
            ]);

            $fail('Verifikasi keamanan sedang tidak dapat diakses. Silakan coba beberapa saat lagi.');

            return;
        }

        if ($response->json('success') !== true) {
            Log::info('Verifikasi reCAPTCHA ditolak.', [
                'error_codes' => $response->json('error-codes'),
                'hostname' => $response->json('hostname'),
            ]);

            $fail('Verifikasi reCAPTCHA gagal. Silakan centang ulang kotak "Saya bukan robot".');
        }
    }
}
