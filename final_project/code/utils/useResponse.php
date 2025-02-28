<?php

// namespace FinalProject\Utils;

function response(int $status = 500, string $message = "Something went wrong!", array $data = [], string $redirect = "/", string $type = 'html')
{
    return [
        'status' => $status,
        'message' => $message,
        'data' => $data,
        'redirect' => $redirect,
        'type' => $type
    ];
};
