<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

class LegalController extends Controller
{
    public function show(string $section)
    {
        $legal = __('legal.' . $section);

        abort_if(!is_array($legal) || !isset($legal['title'], $legal['content']), 404);

        return view('legal.show', [
            'title' => $legal['title'],
            'content' => $legal['content'],
        ]);
    }
}
