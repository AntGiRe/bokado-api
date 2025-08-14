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

    public static function single($data, int $status = 200)
    {
        return response()->json([
            'data' => $data
        ], $status);
    }
}
