<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Image;
use App\Models\Link;
use App\Models\LinkView;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StatsController extends Controller
{
    /**
     * Get global platform statistics.
     * Accessible publicly.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function globalStats()
    {
        $totalUsed = Image::sum('size');
        $totalUsers = User::count();
        $totalImages = Image::count();
        $totalLinks = Link::count();
        $avgPerUser = $totalUsers > 0 ? $totalUsed / $totalUsers : 0;

        $totalLimit = env('STORAGE_LIMIT', 100) * 1024 * 1024 * 1024;
        $storagePercentage = ($totalLimit > 0) ? ($totalUsed / $totalLimit) * 100 : 0;
        $storagePercentage = min(100, $storagePercentage);

        $last30Days = Carbon::now()->subDays(30);
        $last24Hours = Carbon::now()->subHours(24);

        $imagesLast30Days = Image::where('created_at', '>=', $last30Days)->count();
        $imagesLast24Hours = Image::where('created_at', '>=', $last24Hours)->count();

        $linkViewsLast30Days = LinkView::where('created_at', '>=', $last30Days)->count();
        $linkViewsLast24Hours = LinkView::where('created_at', '>=', $last24Hours)->count();

        return response()->json([
            'global' => [
                'total_users' => $totalUsers,
                'total_images' => $totalImages,
                'total_links' => $totalLinks,
                'total_storage_used_mb' => round($totalUsed / 1024 / 1024, 2),
                'total_storage_limit_gib' => round($totalLimit / 1024 / 1024 / 1024, 2),
                'storage_percentage' => round($storagePercentage, 1),
                'average_storage_per_user_mb' => round($avgPerUser / 1024 / 1024, 2),
                'last_30_days' => [
                    'images' => $imagesLast30Days,
                    'link_views' => $linkViewsLast30Days,
                ],
                'last_24_hours' => [
                    'images' => $imagesLast24Hours,
                    'link_views' => $linkViewsLast24Hours,
                ],
            ]
        ]);
    }
}
