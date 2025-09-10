<?php

namespace App\Http\Controllers\Api\v1\PaymentMethods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Http\Traits\HandlesApiResources;
use App\Services\Utils\TranslationFallbackService;

class PaymentMethodController extends Controller
{
    use HandlesApiResources;

    protected $translationService;

    public function __construct(TranslationFallbackService $translationService)
    {
        $this->translationService = $translationService;
    }

    protected function getTranslationService()
    {
        return $this->translationService;
    }

    /**
     * Display a listing of the payment methods.
     */
    public function index(Request $request)
    {
        return $this->resourceIndex($request, PaymentMethod::class);
    }

    /**
     * Display the specified payment method.
     */
    public function show($id)
    {
        return $this->resourceShow($id, PaymentMethod::class);
    }
}
