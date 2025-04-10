<?php

// Inflector is responsible for manipulating/transforming strings.
final class Inflector {
    private function __construct() {}

    // Lowercase returns the provided value in lowercase.
    public static function Lowercase(string $value): string {
        return mb_strtolower($value, 'UTF-8');
    }

    // Latinize returns the original value retaining only Latin-script runes.
    public static function Latinize(string $value): string {
        return preg_replace('/[^a-zA-Z]/', '', $value);
    }
}

class Sentence {
    private string $body;

    public function __construct(string $body) {
        $this->body = $body;
    }

    public function Body(): string {
        return $this->body;
    }

    // IsPangram checks whether the provided sentence is a pangram; that is if 
    // it contains every letter of the Latin-script alphabet at least once.
    public function IsPangram(): bool {
        $runes = [];
        foreach (str_split($this->normalizedBody()) as $rune) {
            $position = ord($rune) - ord('a');
            $runes[$position] = true;
        }
        return count($runes) === 26;
    }

    private function normalizedBody(): string {
        return Inflector::Lowercase(Inflector::Latinize($this->body));
    }
}

$sentences = [
    // Pangrams.
    new Sentence('The quick brown fox jumps over the lazy dog.'),
    new Sentence('Amazingly few discotheques provide jukeboxes.'),
    new Sentence('My girl wove six dozen plaid jackets before she quit.'),
    new Sentence('How vexingly quick daft zebras jump!'),

    // Non-pangrams.
    new Sentence('Hello, world!'),
    new Sentence('How are you?'),
    new Sentence('Lorem ipsum dolor sit amet consectetur, adipisicing elit.'),
    new Sentence('I\'m sorry to hear that.'),
];

foreach ($sentences as $sentence) {
    var_export($sentence->IsPangram());
    echo "\n";
}
