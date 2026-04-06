<?php

namespace App\Http\Controllers;

use App\Models\CommandLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function heatmap(Request $request)
    {
        $days = 365;
        $start = Carbon::now()->subDays($days);
        $logs = CommandLog::where('timestamp', '>=', $start)
            ->selectRaw('DATE(timestamp) as date, COUNT(*) as count')
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        $heatmapData = [];
        for ($i = 0; $i <= $days; $i++) {
            $date = Carbon::now()->subDays($days - $i)->toDateString();
            $heatmapData[] = [
                'date' => $date,
                'count' => $logs[$date]->count ?? 0,
            ];
        }
        return response()->json($heatmapData);
    }

    public function hourlyStats()
    {
        $stats = CommandLog::selectRaw('EXTRACT(HOUR FROM timestamp) as hour, COUNT(*) as total')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();
        return response()->json($stats);
    }

    public function topUsers(Request $request)
    {
        $limit = $request->get('limit', 10);
        $top = CommandLog::selectRaw('user_id, COUNT(*) as total')
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->limit($limit)
            ->get();
        return response()->json($top);
    }
}