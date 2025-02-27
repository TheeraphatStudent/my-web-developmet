<?php

function response(int $status = 500, string $message = "Something went wrong!", array $data = [])
{
    return [
        'status' => $status,
        'message' => $message,
        'data' => $data
    ];
};
