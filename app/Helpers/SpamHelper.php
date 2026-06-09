<?php

namespace App\Helpers;

class SpamHelper
{
    public static function normalize(string $text): string
    {
        $text = strtolower($text);

        // replace common leetspeak
        $text = str_replace(['@', '4'], 'a', $text);
        $text = str_replace(['0'], 'o', $text);
        $text = str_replace(['1', '!'], 'i', $text);
        $text = str_replace(['3'], 'e', $text);

        // remove special characters
        $text = preg_replace('/[^a-z0-9\s]/', '', $text);

        // remove extra spaces
        $text = preg_replace('/\s+/', ' ', $text);

        return $text;
    }

    public static function containsSpam(string $message): bool
    {
        $normalizedMessage = self::normalize($message);

        // 🔥 remove spaces (for f u c k bypass)
        $compactMessage = str_replace(' ', '', $normalizedMessage);

        $badWords = [
            // English
            'fuck','fucking','fucker','shit','shitty','bitch','bastard',
            'asshole','dick','dumbass','crap','piss','motherfucker',
            'arsehole','arse','cock','prick','pussy','twat','bollocks',

            // Filipino
            'gago','tanga','bobo','ulol','tarantado',
            'putangina','putangina',
            'pucha','punyeta','bwisit','leche',
            'yawa','pistingyawa','pestengyawa','pistengyawa',
            'pestingyawa',
            'animalka',
            'otin','oten','bilat','belat','bisong','besong','alimbarok',
            'peste', 'kolera', 'kulera',

            // emoji
            '🤬', '🖕'
        ];

        // ✅ keyword check
        foreach ($badWords as $word) {
            if (
                str_contains($normalizedMessage, $word) ||
                str_contains($compactMessage, $word)
            ) {
                return true;
            }
        }

        // 🔥 regex patterns
        $patterns = [
            '/f+u+c+k+/i',
            '/s+h+i+t+/i',
            '/b+i+t+c+h+/i',
            '/b+a+s+t+a+r+d+/i',
            '/a+s+s+h+o+l+e+/i',
            '/d+i+c+k+/i',
            '/m+o+t+h+e+r+f+u+c+k+e+r+/i',

            '/a+r+s+e+/i',
            '/c+o+c+k+/i',
            '/p+r+i+c+k+/i',
            '/p+u+s+s+y+/i',
            '/t+w+a+t+/i',

            '/g+a+g+o+/i',
            '/t+a+n+g+a+/i',
            '/b+o+b+o+/i',
            '/u+l+o+l+/i',

            '/p+u+t+a+n+g+\s*i+n+a+/i',
            '/p+u+t+a+n+g+i+n+a+/i',

            '/y+a+w+a+/i',
            '/p+i+s+t+i+n+g+\s*y+a+w+a+/i',

            '/a+n+i+m+a+l+\s*k+a+/i',
        ];

        foreach ($patterns as $pattern) {
            if (
                preg_match($pattern, $message) ||
                preg_match($pattern, $compactMessage)
            ) {
                return true;
            }
        }

        return false;
    }
}
