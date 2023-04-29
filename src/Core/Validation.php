<?php

namespace App\Core;

final class Validation
{
    private array $errors = [];

    public function __construct(private Request $request)
    {
    }

    private function resolveOptions(array $options = []): array
    {
        $_options = [];

        $_options['custom_key'] = isset($options['custom_key']) ?
            $options['custom_key'] : null;

        $_options['custom_message'] = isset($options['custom_message']) ?
            $options['custom_message'] : null;

        $_options['when'] = isset($options['when']) ?
            $options['when'] : true;

        return $_options;
    }

    public function required(string $key, array $options = [])
    {
        $options = $this->resolveOptions($options);

        if (
            $options['when'] && empty($this->request->find($key))
        ) {
            $this->errors[] = sprintf(
                $options['custom_message'] ?? "%s wajib di-isi",
                $options['custom_key'] ?? $key
            );
        }

        return $this;
    }

    public function unique(string $key, string $table, array $options = [])
    {
        $options = $this->resolveOptions($options);
        $value = $this->request->find($key);

        $count = (new Database)
            ->query("SELECT id FROM $table WHERE $key=:value LIMIT 1")
            ->bind(":value", $value)
            ->execute()
            ->count();

        if ($options['when'] && $count) $this->errors[] = sprintf(
            $options['custom_message'] ?? "%s sudah terdaftar sebelumnya",
            $options['custom_key'] ?? $key
        );;

        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function isValid(): bool
    {
        return empty($this->errors);
    }
}
