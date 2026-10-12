<?php

namespace App\Support;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use InvalidArgumentException;
use RuntimeException;

/**
 * Menyandikan ID numerik menjadi token pendek yang aman dipakai di URL,
 * supaya ID berurutan (mis. /ba_pdf/80) tidak bisa ditebak atau diubah.
 *
 * Token memakai konstruksi SIV (synthetic IV) deterministik:
 *
 *   iv    = HMAC-SHA256(kunciMac, id)[0..15]
 *   token = base64url(iv . AES-256-CTR(kunciEnkripsi, iv, id))
 *
 * IV tidak dikirim sebagai data terpisah melainkan dihitung ulang dari ID hasil
 * dekripsi, sehingga token jauh lebih pendek daripada Crypt::encryptString
 * (±24 vs ±200 karakter). Karena itu ID yang sama selalu menghasilkan token yang
 * sama, dan perubahan satu bit saja membuat token gagal diverifikasi.
 * Kunci diturunkan dari APP_KEY lewat HKDF, terpisah untuk MAC dan enkripsi.
 */
class UrlId
{
    private const CIPHER = 'aes-256-ctr';

    /** Panjang IV sintetis, sekaligus nilai yang dipakai untuk memverifikasi token. */
    private const IV_LENGTH = 16;

    /** Panjang maksimal ID (menampung seluruh rentang integer positif). */
    private const MAX_ID_LENGTH = 18;

    private const MAC_INFO = 'uptd-wiyung/url-id/mac';

    private const KEY_INFO = 'uptd-wiyung/url-id/enc';

    /** @var array<string, string> */
    private static array $keys = [];

    /**
     * Ubah ID menjadi token yang aman untuk URL.
     */
    public static function encode(int|string $id): string
    {
        $message = (string) $id;

        if (! self::isValidId($message)) {
            throw new InvalidArgumentException('ID yang disandikan harus berupa angka.');
        }

        $iv = self::syntheticIv($message);
        $ciphertext = openssl_encrypt($message, self::CIPHER, self::derivedKey(self::KEY_INFO), OPENSSL_RAW_DATA, $iv);

        if ($ciphertext === false) {
            throw new RuntimeException('Gagal menyandikan ID.');
        }

        return self::base64UrlEncode($iv.$ciphertext);
    }

    /**
     * Kembalikan token menjadi ID numerik.
     *
     * @throws InvalidArgumentException bila token tidak valid atau sudah diubah.
     */
    public static function decode(string $token): int
    {
        $id = self::decodeToken($token) ?? self::decodeLegacyToken($token);

        if ($id === null) {
            throw new InvalidArgumentException('Token ID tidak valid.');
        }

        return $id;
    }

    private static function decodeToken(string $token): ?int
    {
        $payload = base64_decode(strtr($token, '-_', '+/'), true);

        if ($payload === false) {
            return null;
        }

        $length = strlen($payload) - self::IV_LENGTH;

        if ($length < 1 || $length > self::MAX_ID_LENGTH) {
            return null;
        }

        $iv = substr($payload, 0, self::IV_LENGTH);
        $message = openssl_decrypt(substr($payload, self::IV_LENGTH), self::CIPHER, self::derivedKey(self::KEY_INFO), OPENSSL_RAW_DATA, $iv);

        if ($message === false || ! hash_equals(self::syntheticIv($message), $iv) || ! self::isValidId($message)) {
            return null;
        }

        return (int) $message;
    }

    /**
     * Token lama (Crypt::encryptString) tetap diterima agar tautan yang sudah
     * beredar sebelum perubahan ini tidak ikut mati.
     */
    private static function decodeLegacyToken(string $token): ?int
    {
        try {
            $id = Crypt::decryptString(strtr($token, '-_', '+/'));
        } catch (DecryptException) {
            return null;
        }

        return self::isValidId($id) ? (int) $id : null;
    }

    /**
     * IV sintetis yang sekaligus berfungsi sebagai tanda tangan token.
     */
    private static function syntheticIv(string $message): string
    {
        return substr(hash_hmac('sha256', $message, self::derivedKey(self::MAC_INFO), true), 0, self::IV_LENGTH);
    }

    /**
     * Turunkan kunci terpisah dari APP_KEY supaya kunci token tidak pernah sama
     * dengan kunci yang dipakai fitur enkripsi lain.
     */
    private static function derivedKey(string $info): string
    {
        return self::$keys[$info] ??= hash_hkdf('sha256', Crypt::getKey(), 32, $info);
    }

    private static function isValidId(string $id): bool
    {
        return $id !== ''
            && strlen($id) <= self::MAX_ID_LENGTH
            && ctype_digit($id);
    }

    private static function base64UrlEncode(string $binary): string
    {
        return rtrim(strtr(base64_encode($binary), '+/', '-_'), '=');
    }
}
