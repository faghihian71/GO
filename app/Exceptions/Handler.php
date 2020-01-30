<?php

namespace App\Exceptions;

use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Contracts\Queue\EntityNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->ajax() || $request->wantsJson())
        {
            $json = [
                'errors' => [
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage(),
                ],
            ];

            $class = get_class($exception);

            $status_code = 400;
            switch($class) {
                case ModelNotFoundException::class:
                    $status_code = Response::HTTP_NOT_FOUND;
                    break;
                case DuplicateEntryException::class:
                    $status_code = Response::HTTP_CONFLICT;
                    break;
                case ExceedThresholdOfProductsInCardException::class:
                    $status_code = Response::HTTP_BAD_REQUEST;
                    break;
                case  ValidationException::class:
                    return parent::render($request, $exception);
                default:
                    return parent::render($request, $exception);


            }


            return response()->json($json, $status_code);
        }


        return parent::render($request, $exception);
    }
}
