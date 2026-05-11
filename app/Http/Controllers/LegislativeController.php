<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\LegislativeRecord;
use App\Models\Ordinance;
use Carbon\Carbon;

class LegislativeController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->get('tab', 'orbus');

        /* =======================
            ORBUS QUERY
        ======================= */
        $orbusQuery = LegislativeRecord::query();

        if ($request->filled('session')) {
            $orbusQuery->where('session', 'LIKE', '%' . $request->session . '%');
        }

        if ($request->filled('date')) {
            $date = Carbon::parse($request->date);
            $orbusQuery->whereBetween('date', [
                $date->copy()->startOfDay(),
                $date->copy()->endOfDay()
            ]);
        }

        // Group all results first, then paginate the groups
        $allGroups = $orbusQuery
            ->orderBy('date', 'asc')
            ->get()
            ->groupBy(fn ($r) => trim($r->session))
            ->map(function ($group) {
                return $group->map(fn ($record) => [
                    'session'     => trim($record->session),
                    'date'        => Carbon::parse($record->date)->format('Y-m-d'),
                    'title'       => $record->title,
                    'description' => $record->description,
                    'sponsor'     => $record->sponsor,
                    'action_taken'=> $record->action_taken,
                ])->values()->toArray();
            });

        $orbusPage    = $request->get('orbus_page', 1);
        $orbusPerPage = 8;
        $orbusSlice   = $allGroups->slice(($orbusPage - 1) * $orbusPerPage, $orbusPerPage);

        $records = new LengthAwarePaginator(
            $orbusSlice,                    // items for this page
            $allGroups->count(),            // total items
            $orbusPerPage,                  // per page
            $orbusPage,                     // current page
            [
                'path'     => $request->url(),
                'query'    => array_merge($request->query(), ['tab' => 'orbus']),
                'pageName' => 'orbus_page',
            ]
        );

        /* =======================
            ORDINANCE QUERY
        ======================= */
        $ordinancesQuery = Ordinance::query()
            ->where('is_archived', false);

        if ($request->filled('session')) {
            $ordinancesQuery->where('title', 'LIKE', '%' . $request->session . '%');
        }

        if ($request->filled('date')) {
            $date = Carbon::parse($request->date);
            $ordinancesQuery->whereBetween('date', [
                $date->copy()->startOfDay(),
                $date->copy()->endOfDay()
            ]);
        }

        $ordinances = $ordinancesQuery
            ->orderBy('created_at', 'asc')
            ->paginate(10, ['*'], 'ordinance_page')
            ->appends(array_merge($request->query(), ['tab' => 'ordinance']));

        return view('main.legislative_index', compact(
            'records',
            'ordinances',
            'activeTab'
        ));
    }
}
