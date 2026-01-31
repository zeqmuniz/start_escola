<?php

class Validator
{
    public static function validate(array $data, array $rules): array
    {
        $errors = [];
        foreach ($rules as $field => $ruleString) {
            $value = $data[$field] ?? null;
            $rulesList = explode('|', $ruleString);
            foreach ($rulesList as $rule) {
                $param = null;
                if (str_contains($rule, ':')) {
                    [$rule, $param] = explode(':', $rule, 2);
                }
                $rule = trim($rule);

                if ($rule === 'required' && !self::required($value)) {
                    $errors[$field][] = 'Campo obrigatorio.';
                }
                if ($rule === 'email' && $value !== null && $value !== '' && !self::email($value)) {
                    $errors[$field][] = 'Email invalido.';
                }
                if ($rule === 'min' && $value !== null && $value !== '' && !self::min($value, (int) $param)) {
                    $errors[$field][] = 'Minimo de ' . (int) $param . ' caracteres.';
                }
            }
        }
        return $errors;
    }

    private static function required($value): bool
    {
        if (is_array($value)) {
            return count($value) > 0;
        }
        return trim((string) $value) !== '';
    }

    private static function email(string $value): bool
    {
        return (bool) filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    private static function min(string $value, int $min): bool
    {
        return mb_strlen($value) >= $min;
    }
}
