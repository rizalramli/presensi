<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, \Throwable $exception)
    {
        // 404 Error - Template Not Found
        if ($exception instanceof NotFoundHttpException) {
            return response()->view('custom_errors.404', [], 404);
        }

        // 403 Error - Forbidden
        if ($exception instanceof HttpException) {
            return response()->view('custom_errors.403', [], 403);
        }

        // 500 Error - Server Error
        if ($this->isHttpException($exception)) {
            return response()->view('custom_errors.500', [], 500);
        }

        return parent::render($request, $exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
