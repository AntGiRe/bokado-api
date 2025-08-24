<?php

namespace App\Helpers;

class ApiResponseHelper
{
    public static function paginated($paginator)
    {
        return response()->json([
            'data' => $paginator->items(),
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
                'last_page'    => $paginator->lastPage(),
            ],
        ]);
    }

    public static function single($data, ?string $message = null, int $status = 200)
    {
        $response = ['data' => $data];

        if ($message !== null) {
            $response['message'] = $message;
        }

        return response()->json($response, $status);
    }

    public static function message(string $message, int $status = 200)
    {
        return response()->json(['message' => $message], $status);
    }
}
