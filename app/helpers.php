<?php

declare(strict_types=1);

use Illuminate\Container\Container;

if (! function_exists('app')) {
    function app(?string $abstract = null, array $parameters = []): mixed
    {
        $container = Container::getInstance();

        if ($abstract === null) {
            return $container;
        }

        return $container->make($abstract, $parameters);
    }
}

if (! function_exists('config')) {
    function config(array|string|null $key = null, mixed $default = null): mixed
    {
        $config = app('config');

        static $projectPergamentConfigLoaded = false;

        if (! $projectPergamentConfigLoaded && method_exists(app(), 'configPath')) {
            $projectConfigPath = app()->configPath('pergament.php');

            if (is_file($projectConfigPath)) {
                $config->set('pergament', require $projectConfigPath);
            }

            $projectPergamentConfigLoaded = true;
        }

        if ($key === null) {
            return $config;
        }

        if (is_array($key)) {
            foreach ($key as $name => $value) {
                $config->set($name, $value);
            }

            return null;
        }

        return $config->get($key, $default);
    }
}

if (! function_exists('resolve')) {
    function resolve(string $abstract, array $parameters = []): mixed
    {
        return app($abstract, $parameters);
    }
}

if (! function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

        return $value === false ? $default : $value;
    }
}

if (! function_exists('base_path')) {
    function base_path(string $path = ''): string
    {
        return app()->basePath($path);
    }
}

if (! function_exists('public_path')) {
    function public_path(string $path = ''): string
    {
        return app()->publicPath($path);
    }
}

if (! function_exists('resource_path')) {
    function resource_path(string $path = ''): string
    {
        return app()->resourcePath($path);
    }
}

if (! function_exists('storage_path')) {
    function storage_path(string $path = ''): string
    {
        return app()->storagePath($path);
    }
}

if (! function_exists('request')) {
    function request(?string $key = null, mixed $default = null): mixed
    {
        $request = app('request');

        return $key === null ? $request : $request->input($key, $default);
    }
}

if (! function_exists('route')) {
    function route(string $name, mixed $parameters = [], bool $absolute = true): string
    {
        return app('url')->route($name, $parameters, $absolute);
    }
}

if (! function_exists('asset')) {
    function asset(string $path, ?bool $secure = null): string
    {
        return app('url')->asset($path, $secure);
    }
}

if (! function_exists('view')) {
    function view(?string $view = null, array $data = [], array $mergeData = []): mixed
    {
        $factory = app('view');

        return $view === null ? $factory : $factory->make($view, $data, $mergeData);
    }
}

if (! function_exists('now')) {
    function now(DateTimeZone|string|null $tz = null): Illuminate\Support\Carbon
    {
        return Illuminate\Support\Carbon::now($tz);
    }
}
