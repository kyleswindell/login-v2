<?php

namespace App\Core\Runtime;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Http\Request;

final readonly class Resolver
{
    public function __construct(
        private Config $config,
    ) {}

    public function resolve(?Request $request = null): Context
    {
        return new Context(
            key: 'parasolutions',
            name: 'Parasolutions',
            url: $this->url($request),
        );
    }

    private function url(?Request $request): string
    {
        if ($request instanceof Request) {
            $schemeAndHost = $request->getSchemeAndHttpHost();

            if ($schemeAndHost !== '') {
                return $this->normalizeUrl($schemeAndHost);
            }
        }

        return $this->normalizeUrl((string) $this->config->get('app.url', 'http://localhost'));
    }

    private function normalizeUrl(string $url): string
    {
        return rtrim($url, '/');
    }
}
