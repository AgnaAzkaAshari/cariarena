<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

    if (file_exists($cache = __DIR__.'/cache/routes-v7.php')) {
    unlink($cache);
}
if (file_exists($cache = __DIR__.'/cache/packages.php')) {
    unlink($cache);
}
if (file_exists($cache = __DIR__.'/cache/services.php')) {
    unlink($cache);
}