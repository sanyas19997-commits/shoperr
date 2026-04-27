<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use Illuminate\Http\Request;

class ActionLogController extends Controller
{
    public function index(Request $request)
    {
        return ActionLog::with('user:id,name,email')
            ->latest()
            ->paginate($request->integer('per_page', 30));
    }
}
