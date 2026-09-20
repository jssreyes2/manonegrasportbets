<?php
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException; // <-- Asegúrate de importar esto arriba

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->renderable(function (Throwable $e, Request $request) {
            
            if ($e instanceof ValidationException) {
                return null;
            }
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Ocurrió un error inesperado en el servidor.',
                    'edit'    => false,
                    'debug'   => $e->getMessage()
                ], 500);
            }
        });
    }
}