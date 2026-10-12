<?php

namespace App\Support;

/**
 * Narasi Berita Acara ditulis lewat editor rich text (Summernote), jadi isinya
 * tersimpan sebagai HTML (mis. "<p>tunggakan dibayar ...</p><p>...</p>").
 *
 * Tabel daftar butuh teks biasa tanpa tag, sedangkan dokumen PDF tetap butuh
 * formatnya — dua utilitas di bawah melayani keduanya.
 */
class Narasi
{
    /** Tag yang boleh ikut dicetak (sesuai toolbar Summernote: bold, list, tabel, paragraf). */
    private const TAG_DIIZINKAN = '<p><br><b><strong><i><em><u><s><span><div><ul><ol><li>'
        . '<table><thead><tbody><tr><td><th><h1><h2><h3><h4><h5><h6><blockquote><pre><code><hr>';

    /**
     * Teks biasa untuk tabel: tag dibuang, batas paragraf menjadi baris baru
     * supaya "nl2br" tetap menampilkan susunan paragraf aslinya.
     */
    public static function teks(?string $html): string
    {
        if (blank($html)) {
            return '';
        }

        $text = preg_replace('#<br\s*/?>#i', "\n", $html);
        $text = preg_replace('#</(p|div|li|tr|h[1-6]|blockquote|pre)\s*>#i', "\n", $text);
        $text = strip_tags($text);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = str_replace(["\xc2\xa0", "\r\n", "\r"], [' ', "\n", "\n"], $text);

        $lines = array_filter(array_map(
            fn ($line) => trim(preg_replace('/[ \t]+/', ' ', $line)),
            explode("\n", $text)
        ), fn ($line) => $line !== '');

        return implode("\n", $lines);
    }

    /**
     * HTML yang aman untuk dicetak ke PDF / ditampilkan sebagai pratinjau.
     * Skrip, tag bermuatan sumber luar, dan seluruh atribut (onclick, src, style,
     * colspan, dst.) dibuang lebih dulu supaya cetakan tetap rapi dan aman.
     */
    public static function aman(?string $html): string
    {
        if (blank($html)) {
            return '';
        }

        // Buang blok berbahaya beserta isinya.
        $html = preg_replace('#<(script|style|iframe|object|embed|noscript|svg|math)\b.*?</\1\s*>#is', '', $html);

        // Buang tag yang tidak dipakai editor & berpotensi memuat sumber luar.
        $html = preg_replace(
            '#<(script|style|iframe|object|embed|noscript|svg|math|link|meta|base|img|input|button|textarea|form|select)\b[^>]*>#is',
            '',
            $html
        );

        $html = strip_tags($html, self::TAG_DIIZINKAN);

        // Tanpa atribut: mencegah onerror/onclick dan permintaan berkas dari luar.
        $html = preg_replace('#<([a-z][a-z0-9]*)\b[^>]*>#i', '<$1>', $html);

        return trim($html);
    }
}
