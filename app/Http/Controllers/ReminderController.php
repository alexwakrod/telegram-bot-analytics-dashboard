<?php

namespace App\Http\Controllers;

use App\Models\Reminder;

class ReminderController extends Controller
{
    public function index()
    {
        return Reminder::where('done', false)->orderBy('remind_at')->get();
    }

    public function destroy($id)
    {
        Reminder::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}