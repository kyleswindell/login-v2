<?php

namespace App\Platform\Docs;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use RuntimeException;

class DocsRepository
{
    /**
     * @var list<string>
     */
    private array $allowedExtensions = ['md', 'txt', 'json', 'yml', 'yaml'];

    public function countFiles(): int
    {
        return count($this->allFiles($this->rootPath()));
    }

    public function defaultFilePath(): string
    {
        return '00 - Start Here.md';
    }

    /**
     * @return list<array{name: string, path: string, type: string, children?: list<array{name: string, path: string, type: string, children?: list<mixed>}>}>
     */
    public function tree(): array
    {
        return $this->treeForDirectory($this->rootPath());
    }

    /**
     * @return array{name: string, path: string, extension: string, content: string, rendered: string}|null
     */
    public function file(string $relativePath): ?array
    {
        if ($relativePath === '') {
            return null;
        }

        try {
            $path = $this->resolvePath($relativePath);
        } catch (RuntimeException) {
            return null;
        }

        if (! File::isFile($path)) {
            return null;
        }

        $extension = Str::lower(File::extension($path));

        if (! in_array($extension, $this->allowedExtensions, true)) {
            return null;
        }

        $content = File::get($path);

        $relativeFilePath = $this->relativePath($path);

        return [
            'name' => File::name($path),
            'path' => $relativeFilePath,
            'extension' => $extension,
            'content' => $content,
            // Render Markdown in a locked-down mode so platform users can review notes
            // in-app without turning the docs browser into an arbitrary HTML surface.
            'rendered' => $extension === 'md'
                ? $this->rewriteLinks(
                    Str::markdown($content, [
                        'html_input' => 'strip',
                        'allow_unsafe_links' => false,
                    ]),
                    $relativeFilePath,
                )
                : nl2br(e($content)),
        ];
    }

    private function rootPath(): string
    {
        return base_path('docs');
    }

    private function resolvePath(string $relativePath): string
    {
        $candidatePath = $this->rootPath().DIRECTORY_SEPARATOR.ltrim($relativePath, DIRECTORY_SEPARATOR);
        $realPath = realpath($candidatePath);
        $realRoot = realpath($this->rootPath());

        // Constrain repository reads to the docs root so this browser cannot escape into
        // the rest of the application filesystem through crafted relative paths.
        if ($realPath === false || $realRoot === false || ! str_starts_with($realPath, $realRoot)) {
            throw new RuntimeException('Invalid docs path.');
        }

        return $realPath;
    }

    /**
     * @return list<array{name: string, path: string, type: string, children?: list<array{name: string, path: string, type: string, children?: list<mixed>}>}>
     */
    private function treeForDirectory(string $directory): array
    {
        /** @var Collection<int, string> $items */
        $items = collect(File::directories($directory))
            ->filter(fn (string $path): bool => ! str_starts_with(File::basename($path), '.'))
            ->sort()
            ->values()
            ->concat(
                collect($this->allFiles($directory))
                    ->filter(fn (string $path): bool => dirname($path) === $directory)
                    ->sort()
                    ->values()
            );

        return $items->map(function (string $path): array {
            if (File::isDirectory($path)) {
                return [
                    'name' => File::basename($path),
                    'path' => $this->relativePath($path),
                    'type' => 'directory',
                    'children' => $this->treeForDirectory($path),
                ];
            }

            return [
                'name' => File::basename($path),
                'path' => $this->relativePath($path),
                'type' => 'file',
            ];
        })->all();
    }

    /**
     * @return list<string>
     */
    private function allFiles(string $directory): array
    {
        return collect(File::allFiles($directory))
            ->map(fn ($file): string => $file->getRealPath())
            ->filter(fn (string $path): bool => ! str_starts_with(File::basename($path), '.'))
            ->filter(function (string $path): bool {
                return in_array(Str::lower(File::extension($path)), $this->allowedExtensions, true);
            })
            ->values()
            ->all();
    }

    private function relativePath(string $path): string
    {
        return ltrim(Str::after($path, $this->rootPath()), DIRECTORY_SEPARATOR);
    }

    private function rewriteLinks(string $html, string $currentPath): string
    {
        return preg_replace_callback('/href="([^"]+)"/', function (array $matches) use ($currentPath): string {
            $href = html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8');

            if (
                $href === '' ||
                str_starts_with($href, '#') ||
                preg_match('/^(https?:|mailto:|tel:)/i', $href) === 1
            ) {
                return $matches[0];
            }

            $resolvedPath = $this->resolveLinkedPath($currentPath, $href);

            if ($resolvedPath === null) {
                return $matches[0];
            }

            return 'href="'.e(route('platform.docs.index', ['path' => $resolvedPath])).'"';
        }, $html) ?? $html;
    }

    private function resolveLinkedPath(string $currentPath, string $href): ?string
    {
        $cleanHref = Str::before($href, '#');
        $decodedHref = urldecode($cleanHref);

        if ($decodedHref === '') {
            return null;
        }

        $baseDirectory = dirname($currentPath);
        $combinedPath = $baseDirectory === '.'
            ? $decodedHref
            : $baseDirectory.DIRECTORY_SEPARATOR.$decodedHref;

        try {
            return $this->relativePath($this->resolvePath($combinedPath));
        } catch (RuntimeException) {
            return null;
        }
    }
}
