<?php

namespace App\Support;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use InvalidArgumentException;

/**
 * Menyandikan ID numerik menjadi token terenkripsi yang aman dipakai di URL,
 * supaya ID berurutan (mis. /ba_pdf/80) tidak bisa ditebak atau diubah sembarangan.
 *
 * Token sekaligus berfungsi sebagai tanda tangan: nilai yang diubah akan gagal didekripsi.
 */
class UrlId
{
    /**
     * Ubah ID menjadi token yang aman untuk URL.
     */
    public static function encode(int|string $id): string
    {
        $token = Crypt::encryptString((string) $id);

        // Base64 standar memakai "+", "/", dan "=" yang bermasalah di URL.
        return rtrim(strtr($token, '+/', '-_'), '=');
    }

    /**
     * Kembalikan token menjadi ID numerik.
     *
     * @throws InvalidArgumentException bila token tidak valid atau sudah diubah.
     */
    public static function decode(string $token): int
    {
        $base64 = strtr($token, '-_', '+/');
        $base64 .= str_repeat('=', (4 - strlen($base64) % 4) % 4);

        try {
            $id = Crypt::decryptString($base64);
        } catch (DecryptException $e) {
            throw new InvalidArgumentException('Token ID tidak valid.', 0, $e);
        }

        if (! ctype_digit($id)) {
            throw new InvalidArgumentException('Token ID tidak valid.');
        }

        return (int) $id;
    }
}
