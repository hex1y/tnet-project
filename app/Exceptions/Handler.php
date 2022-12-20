<?php

namespace App\Exceptions;

use App\Traits\ReturnsApiResponses;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use function get_class;

class Handler extends ExceptionHandler
{
    use ReturnsApiResponses;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api*')) {
                return match (get_class($e)) {
                    NotFoundHttpException::class => $this->error(404, 'Requested entry was not found'),
                    ValidationException::class => $this->validatorError($e->validator),
                    AuthenticationException::class => $this->unauthorized('Unauthorized'),
                    // etc...
                    default => $this->exception($e),
                };
            }
            return parent::render($request, $e);
        });
    }
}
