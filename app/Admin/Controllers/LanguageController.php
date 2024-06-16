<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Language\SetStatusRequest;
use App\Http\Resources\Admin\ConfigSystemResource;
use App\Http\Resources\Admin\LanguageResource;
use App\Models\Language\Language;
use App\Models\System\ConfigSystem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class ServicesController
 *
 * @package App\Admin\Controllers
 */
class LanguageController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function getLanguages(): AnonymousResourceCollection
    {
        return LanguageResource::collection(Language::all());
    }

    public function setStatus(
        SetStatusRequest $request
    ): void
    {
        Language::query()
            ->where('id', $request->input('id'))
            ->update([
                'active' => $request->input('status')
            ]);
    }
}
