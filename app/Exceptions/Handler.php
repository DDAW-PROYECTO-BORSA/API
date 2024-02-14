<?php

namespace App\Exceptions;

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
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

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (Throwable $exception) {

            if (request()->is('api*'))
            {
                if ($exception instanceof ModelNotFoundException) {
                    return response()->json(['error' => 'Elemento no encontrado'], 404);
                }
                elseif ($exception instanceof AuthenticationException) {
                    return response()->json(['error' => 'Usuario no autenticado'], 401);
                }
                elseif ($exception instanceof ValidationException) {
                    return response()->json([
                        'error' => 'Datos no válidos',
                        'errors' => $exception->validator->getMessageBag(),
                    ], 400);
                }
                elseif ($exception instanceof QueryException) {
                    return response()->json(['error' => 'Datos no válidos'], 400);
                }
                elseif (isset($exception)) {
                    return response()->json(['error' => 'Error en la aplicación ('.get_class($exception).'):'.$exception->getMessage()], 500);
                }
            }
        });
    }
}
