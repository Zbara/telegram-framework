<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\View;

/**
 * Class CanvasController
 *
 * @package App\Admin\Controllers
 */
class CanvasController extends Controller
{
    /**
     * Returns the canvas view for the admin
     *
     * @param string $route
     * @return Application|Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function canvas(string $route = '/'): Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|Application
    {
        return view('admin', [
            'route' => $route
        ]);
    }
}
