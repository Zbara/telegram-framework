<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ConfigSystemResource;
use App\Http\Resources\Admin\LanguageResource;
use App\Models\Language\Language;
use App\Models\System\ConfigSystem;
use Illuminate\Http\JsonResponse;

/**
 * Class ServicesController
 *
 * @package App\Admin\Controllers
 */
class ServicesController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getConfig(): JsonResponse
    {
        return response()->json([
            'config' => ConfigSystemResource::collection(
                ConfigSystem::query()
                    ->get()
            ),
            'language' => LanguageResource::collection(
                Language::query()
                    ->active()
                    ->get()
            )
        ]);
    }

    public function getMain()
    {

    }
}
