<?php

namespace App\Exceptions;

use App\Http\Traits\ApiDesignTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Handler extends ExceptionHandler
{
    use ApiDesignTrait;
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
        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            if ($request->is('api/*')) {
                return $this->ApiResponse(403,'You Have No Permission To Do It');
            }
         });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is("api/*")) {
                return $this->ApiResponse(404,'Record not found');
            }
            return $this->ApiResponse(404,'Error',$e->getMessage());
        });
        $this->renderable(function (PermissionDoesNotExist $e, $request) {
            if ($request->is("api/*")) {
                return $this->ApiResponse(404,'You Have No Permission To Do It');
            }
            return $this->ApiResponse(404,'Error',$e->getMessage());
        });
    }
}
