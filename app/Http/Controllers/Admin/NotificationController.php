<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::query()->orderByDesc('id');

        if ($request->filled('keyword')) {
            $keyword = trim((string) $request->keyword);
            $query->where(function ($q) use ($keyword) {
                $q->where('message', 'like', "%{$keyword}%")
                    ->orWhere('customer_name', 'like', "%{$keyword}%")
                    ->orWhere('customer_phone', 'like', "%{$keyword}%")
                    ->orWhere('ip', 'like', "%{$keyword}%");
            });
        }

        $notifications = $query->paginate(20)->withQueryString();

        if (Schema::hasTable('notifications') && Schema::hasColumn('notifications', 'is_read')) {
            $ids = $notifications->getCollection()->pluck('id')->filter()->values();
            if ($ids->count()) {
                Notification::query()
                    ->whereIn('id', $ids)
                    ->where('is_read', 0)
                    ->update(['is_read' => 1]);
            }
        }

        return view('admin.notification.index', compact('notifications'));
    }

    public function create()
    {
        return redirect()->route('notification.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('notification.index');
    }

    public function show($id)
    {
        return redirect()->route('notification.index');
    }

    public function edit($id)
    {
        return redirect()->route('notification.index');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('notification.index');
    }

    public function destroy($id)
    {
        return redirect()->route('notification.index');
    }

    public function massUpdate(Request $request)
    {
        return response()->json([
            'success' => false,
            'message' => 'Not implemented yet',
        ], 501);
    }

    public function list(Request $request)
    {
        $limit = (int) $request->get('limit', 10);
        $limit = max(0, min(50, $limit));

        $markRead = $request->boolean('mark_read', false);
        $includeLatest = $request->boolean('include_latest', false);

        $hasIsRead = Schema::hasTable('notifications') && Schema::hasColumn('notifications', 'is_read');

        $notifications = collect();

        if ($limit > 0) {
            $notifications = Notification::query()
                ->orderByDesc('id')
                ->limit($limit)
                ->get($hasIsRead ? ['id', 'message', 'created_at', 'is_read'] : ['id', 'message', 'created_at']);

            if ($markRead && $hasIsRead) {
                $ids = $notifications->pluck('id')->filter()->values();
                if ($ids->count()) {
                    Notification::query()
                        ->whereIn('id', $ids)
                        ->where('is_read', 0)
                        ->update(['is_read' => 1]);
                }
            }
        }

        $unread = $hasIsRead
            ? (int) Notification::query()->where('is_read', 0)->count()
            : (int) Notification::query()->count();

        $latest = null;
        if ($includeLatest && $unread > 0) {
            $latestQuery = Notification::query()->orderByDesc('id');
            if ($hasIsRead) {
                $latestQuery->where('is_read', 0);
            }

            $latestItem = $latestQuery->first(['id', 'message', 'created_at']);
            if ($latestItem) {
                $latest = [
                    'id' => $latestItem->id,
                    'message' => (string) $latestItem->message,
                    'time' => $latestItem->created_at ? Carbon::parse($latestItem->created_at)->diffForHumans() : '',
                    'created_at' => $latestItem->created_at ? Carbon::parse($latestItem->created_at)->toDateTimeString() : null,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'unread' => $unread,
            'latest' => $latest,
            'data' => $notifications->map(function ($item) {
                return [
                    'id' => $item->id,
                    'message' => (string) $item->message,
                    'time' => $item->created_at ? Carbon::parse($item->created_at)->diffForHumans() : '',
                    'created_at' => $item->created_at ? Carbon::parse($item->created_at)->toDateTimeString() : null,
                    'is_read' => property_exists($item, 'is_read') ? (int) $item->is_read : null,
                ];
            })->values(),
        ]);
    }
}
