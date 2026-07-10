<?php

namespace App\Core\Runtime;

final readonly class Context
{
    public function __construct(
        public string $key,
        public string $name,
        public string $url,
    ) {}

    /**
     * @return array{key: string, name: string, url: string}
     */
    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'name' => $this->name,
            'url' => $this->url,
        ];
    }
}
