<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index(Request $request)
    {
        $q = MenuItem::query();
        if ($p = $request->string('placement')->toString()) {
            $q->where('placement', $p);
        }
        return $q->orderBy('placement')->orderBy('sort_order')->paginate($request->integer('per_page', 100));
    }

    public function show(MenuItem $menuItem)
    {
        return response()->json(['data' => $menuItem]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $item = MenuItem::create($data);
        ActionLog::log('menu.create', $item, $data);
        return response()->json(['data' => $item], 201);
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $data = $this->validated($request);
        $menuItem->update($data);
        ActionLog::log('menu.update', $menuItem, $data);
        return response()->json(['data' => $menuItem->fresh()]);
    }

    public function destroy(Request $request, MenuItem $menuItem)
    {
        if (! $request->user()->isAdmin()) {
            return response()->json(['message' => 'Удаление доступно только администратору.'], 403);
        }
        ActionLog::log('menu.delete', $menuItem);
        $menuItem->delete();
        return response()->json(['message' => 'Удалено.']);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'placement' => ['required', 'string', 'max:30'],
            'title' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
            'open_new_tab' => ['nullable', 'boolean'],
        ]);
        $data['is_active'] = (bool) ($data['is_active'] ?? false);
        $data['open_new_tab'] = (bool) ($data['open_new_tab'] ?? false);
        return $data;
    }
}
