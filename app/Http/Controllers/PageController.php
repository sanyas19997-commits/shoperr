<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function show(string $slug)
    {
        $page = Page::query()->where('slug', $slug)->where('is_active', true)->firstOrFail();

        return Inertia::render('Shop/Page', compact('page'));
    }

    public function contact()
    {
        return Inertia::render('Shop/Contact');
    }

    public function contactSubmit(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        ContactMessage::create($data);

        return back()->with('success', 'Сообщение отправлено. Мы свяжемся с вами в ближайшее время.');
    }

    public function about()
    {
        $page = Page::query()->where('slug', 'about')->where('is_active', true)->first();

        return Inertia::render('Shop/About', compact('page'));
    }
}
