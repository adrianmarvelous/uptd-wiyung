<?php

use App\Support\UrlId;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

// Sengaja di suite Unit: UrlId tidak menyentuh database, jadi tidak perlu
// RefreshDatabase yang diwajibkan untuk suite Feature.
uses(TestCase::class);

it('round-trips an ID through encode and decode', function (int $id) {
    expect(UrlId::decode(UrlId::encode($id)))->toBe($id);
})->with([1, 9, 80, 1234, 999999]);

it('produces a token that is far shorter than the default Laravel encryption', function () {
    expect(strlen(UrlId::encode(80)))
        ->toBeLessThan(strlen(Crypt::encryptString('80')))
        ->toBeLessThanOrEqual(30);
});

it('only uses characters that are safe inside a URL', function () {
    expect(UrlId::encode(123456789))->toMatch('/^[A-Za-z0-9_-]+$/');
});

it('is deterministic so the same ID always yields the same token', function () {
    expect(UrlId::encode(80))->toBe(UrlId::encode(80));
});

it('rejects a token whose payload has been altered', function () {
    $token = UrlId::encode(80);
    $tampered = substr($token, 0, -1).($token[strlen($token) - 1] === 'A' ? 'B' : 'A');

    expect(fn () => UrlId::decode($tampered))->toThrow(InvalidArgumentException::class);
});

it('rejects tokens that were not produced by UrlId', function (string $token) {
    expect(fn () => UrlId::decode($token))->toThrow(InvalidArgumentException::class);
})->with(['', 'abc', 'eyJpdiI6Inh4eCJ9', str_repeat('a', 200)]);

it('rejects a token whose payload length does not match an ID', function () {
    expect(fn () => UrlId::decode(substr(UrlId::encode(80), 0, 5)))
        ->toThrow(InvalidArgumentException::class);
});

it('still decodes tokens created with the previous Crypt based format', function () {
    $legacy = rtrim(strtr(Crypt::encryptString('482'), '+/', '-_'), '=');

    expect(UrlId::decode($legacy))->toBe(482);
});

it('refuses to encode values that are not numeric IDs', function () {
    expect(fn () => UrlId::encode('abc'))->toThrow(InvalidArgumentException::class);
});
