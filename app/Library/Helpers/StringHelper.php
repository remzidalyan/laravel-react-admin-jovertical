<?php

namespace App\Library\Helpers;

use Illuminate\Support\Str;

class StringHelper
{
    public static function registerMacros()
    {
        if (!Str::hasMacro('cleanSpaces')) {
            Str::macro('cleanSpaces', function ($value) {
                return preg_replace('~(\s|\x{3164})+~u', ' ', preg_replace('~^[\s\x{FEFF}]+|[\s\x{FEFF}]+$~u', '', $value));

            });
        }

        if (!Str::hasMacro('trUppercase')) {
            Str::macro('trUppercase', function (string $value): string {
                return $this->tr_strtoupper($value);
            });
        }

        if (!Str::hasMacro('trLowercase')) {
            Str::macro('trLowercase', function (string $value): string {
                return $this->tr_strtolower($value);
            });
        }

        if (!Str::hasMacro('trUppercaseFirst')) {
            Str::macro('trUppercaseFirst', function (string $value): string {
                return $this->tr_uppercase_first($value);
            });
        }

        if (!Str::hasMacro('trLowercaseFirst')) {
            Str::macro('trLowercaseFirst', function (string $value): string {
                return $this->tr_lowercase_first($value);
            });
        }

        if (!Str::hasMacro('trUppercaseWords')) {
            Str::macro('trUppercaseWords', function (string $value): string {
                return $this->tr_uppercase_words($value);
            });
        }
    }


    private function tr_strtoupper(string $value): string
    {
        return mb_strtoupper(str_replace('i', 'İ', $value), 'UTF-8');
    }


    private function tr_strtolower(string $value): string
    {
        return mb_strtolower(str_replace(['İ', 'I'], ['i', 'ı'], $value), 'UTF-8');
    }


    private function tr_uppercase_first(string $value): string
    {
        $tmp = preg_split('//u', $value, 2, PREG_SPLIT_NO_EMPTY);
        $more = $tmp[1] ?? '';

        return mb_convert_case($this->tr_strtoupper($tmp[0]), MB_CASE_TITLE, 'UTF-8') . $this->tr_strtolower($more);
    }


    private function tr_lowercase_first(string $value): string
    {
        $tmp = preg_split('//u', $value, 2, PREG_SPLIT_NO_EMPTY);
        $more = $tmp[1] ?? '';

        return mb_convert_case($this->tr_strtolower($tmp[0]), MB_CASE_LOWER, 'UTF-8') . $more;
    }

    private function tr_uppercase_words(string $value): string
    {
        $result = '';
        foreach (explode(' ', $value) as $word) {
            if ($word === ' ') {
                $result .= $word;
            } else if (strlen($word) === 0) {
                $result .= ' ' . $word;
            } else {
                $result .= ' ' . $this->tr_uppercase_first($word);
            }
        }

        return substr($result, 1);
    }
}
