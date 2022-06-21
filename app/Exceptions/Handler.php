<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
  /**
   * A list of the exception types that are not reported.
   *
   * @var array
   */
  protected $dontReport = [
    InvalidRequestException::class,   // 不写入日志

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


  public function report(Throwable $exception)
  {
    parent::report($exception);
  }


  public function render($request, Throwable $exception)
  {
   
    // if ($this->isHttpException($exception)) {
    //   if (view()->exists('errors.error')) {

    //     if($exception->getStatusCode() == 429){
    //       // $message = $exception->getMessage();
    //       $message = '提交频率过高，休息1分钟再试试吧！';
    //     }
    //     if($exception->getStatusCode() == 403){
    //       $message = '访问受限制！';
    //     }
    //     return response()->view('errors.error', ['message' => $message,'code' => $exception->getStatusCode()]);
    //   }
    // }

    // if($exception->getStatusCode() == 403){
    //   return redirect()->back();
    // }


    return parent::render($request, $exception);
  }
}
