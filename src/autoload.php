<?php

// SPDX-FileCopyrightText: 2024 Cyril AUGIER <cicxjo@posteo.net>, et al.
//
// SPDX-License-Identifier: GPL-3.0-or-later

declare(strict_types=1);

namespace Feed2Email;

class Autoload
{
    private array $namespaces = [];

    public function register(): void
    {
        spl_autoload_register([$this, 'loadClass'], true, true);
    }

    public function addNamespace(string $namespacePrefix, string $namespaceBaseDirectory): self
    {
        $namespacePrefix = trim($namespacePrefix, '\\');
        $namespaceBaseDirectory = trim($namespaceBaseDirectory, DIRECTORY_SEPARATOR);

        $this->namespaces[$namespacePrefix] = $namespaceBaseDirectory;

        return $this;
    }

    public function loadClass(string $className): string|false
    {
        $namespace = array_filter(
            $this->namespaces,
            fn($namespacePrefix) => str_starts_with($className, $namespacePrefix),
            ARRAY_FILTER_USE_KEY
        );

        if (!$namespace) {
            return false;
        }

        $namespacePrefix = key($namespace);
        $file = $this->translateClassNametoFileName($namespacePrefix, $className);

        if (file_exists($file)) {
            require_once($file);
            return $file;
        }

        return false;
    }

    private function translateClassNametoFileName(string $namespacePrefix, string $className): string
    {
        $namespaceBaseDirectory = $this->namespaces[$namespacePrefix];
        $relativeClassName = substr($className, strlen($namespacePrefix));

        return $namespaceBaseDirectory . str_replace('\\', '/', $relativeClassName) . '.php';
    }
}
