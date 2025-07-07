<?php

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

public function render($request, Throwable $exception)
{
    if ($exception instanceof HttpException) {
        $status = $exception->getStatusCode();

        return response()->view('pages.error', [
            'code' => $status,
            'title' => $this->getTitle($status),
            'message' => $exception->getMessage(),
        ], $status);
    }

    return parent::render($request, $exception);
}

protected function getTitle(int $status): string
{
    return match ($status) {
        400 => __('Bad Request'),
        401 => __('Unauthorized'),
        403 => __('Forbidden'),
        404 => __('Not Found'),
        419 => __('Page Expired'),
        429 => __('Too Many Requests'),
        500 => __('Server Error'),
        503 => __('Service Unavailable'),
        default => __('Error'),
    };
}
