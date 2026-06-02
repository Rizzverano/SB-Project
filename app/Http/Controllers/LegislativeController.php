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
        $activeTab = $request->get('tab', 'ordinance');

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

        // Keep only the seven official agenda titles and group by session + date
        $agendaTitles = [
            'LOCAL CHIEF EXECUTIVE HOUR',
            'READING AND REFERRAL OF THE PROPOSED MEASURES',
            'COMMITTEE REPORT',
            'UNFINISHED BUSINESS',
            'BUSINESS FOR THE DAY',
            'UNASSIGNED BUSINESS',
            'OTHER MATTERS',
        ];

        $allGroups = $orbusQuery
            ->orderBy('date', 'asc')
            ->get()
            ->filter(function ($record) use ($agendaTitles) {
                return in_array(strtoupper(trim($record->title)), $agendaTitles, true);
            })
            ->groupBy(function ($record) {
                return trim($record->session) . '|' . Carbon::parse($record->date)->format('Y-m-d');
            })
            ->map(function ($group, $groupKey) use ($agendaTitles) {
                [$session, $date] = explode('|', $groupKey);

                $sorted = $group->sortBy(function ($record) use ($agendaTitles) {
                    return array_search(strtoupper(trim($record->title)), $agendaTitles, true);
                })->map(function ($record) use ($session, $date) {
                    return [
                        'session'     => trim($session),
                        'date'        => Carbon::parse($date)->format('Y-m-d'),
                        'title'       => strtoupper(trim($record->title)),
                        'description' => $record->description,
                        'sponsor'     => $record->sponsor,
                        'action_taken'=> $record->action_taken,
                    ];
                })->values()->toArray();

                return [
                    'session_key'   => $groupKey,
                    'session_label' => trim($session),
                    'date'          => Carbon::parse($date)->format('Y-m-d'),
                    'records'       => $sorted,
                ];
            })->values();

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
            OLD ORBUS QUERY
        ======================= */
        $oldOrbusQuery = LegislativeRecord::onlyTrashed();

        if ($request->filled('session')) {
            $oldOrbusQuery->where('session', 'LIKE', '%' . $request->session . '%');
        }

        if ($request->filled('date')) {
            $date = Carbon::parse($request->date);
            $oldOrbusQuery->whereBetween('date', [
                $date->copy()->startOfDay(),
                $date->copy()->endOfDay()
            ]);
        }

        $oldGroups = $oldOrbusQuery
            ->orderBy('date', 'asc')
            ->get()
            ->filter(function ($record) use ($agendaTitles) {
                return in_array(strtoupper(trim($record->title)), $agendaTitles, true);
            })
            ->groupBy(function ($record) {
                return trim($record->session) . '|' . Carbon::parse($record->date)->format('Y-m-d');
            })
            ->map(function ($group, $groupKey) use ($agendaTitles) {
                [$session, $date] = explode('|', $groupKey);

                $sorted = $group->sortBy(function ($record) use ($agendaTitles) {
                    return array_search(strtoupper(trim($record->title)), $agendaTitles, true);
                })->map(function ($record) use ($session, $date) {
                    return [
                        'session'     => trim($session),
                        'date'        => Carbon::parse($date)->format('Y-m-d'),
                        'title'       => strtoupper(trim($record->title)),
                        'description' => $record->description,
                        'sponsor'     => $record->sponsor,
                        'action_taken'=> $record->action_taken,
                    ];
                })->values()->toArray();

                return [
                    'session_key'   => 'old_' . $groupKey,
                    'session_label' => trim($session),
                    'date'          => Carbon::parse($date)->format('Y-m-d'),
                    'records'       => $sorted,
                ];
            })->values();

        $oldOrbusPage    = $request->get('old_orbus_page', 1);
        $oldOrbusPerPage = 8;
        $oldOrbusSlice   = $oldGroups->slice(($oldOrbusPage - 1) * $oldOrbusPerPage, $oldOrbusPerPage);

        $oldRecords = new LengthAwarePaginator(
            $oldOrbusSlice,
            $oldGroups->count(),
            $oldOrbusPerPage,
            $oldOrbusPage,
            [
                'path'     => $request->url(),
                'query'    => array_merge($request->query(), ['tab' => 'old_orbus']),
                'pageName' => 'old_orbus_page',
            ]
        );

        /* =======================
            ORDINANCE QUERY
        ======================= */
        $ordinancesQuery = Ordinance::query()
            ->where('is_archived', false)
            ->where('published', true);

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

        /* =======================
            OLD ORDINANCE QUERY
        ======================= */
        $oldOrdinancesQuery = Ordinance::query()
            ->where('is_archived', true)
            ->where('published', true);


        if ($request->filled('session')) {
            $oldOrdinancesQuery->where('title', 'LIKE', '%' . $request->session . '%');
        }

        if ($request->filled('date')) {
            $date = Carbon::parse($request->date);
            $oldOrdinancesQuery->whereBetween('date', [
                $date->copy()->startOfDay(),
                $date->copy()->endOfDay()
            ]);
        }

        $oldOrdinances = $oldOrdinancesQuery
            ->orderBy('created_at', 'asc')
            ->paginate(10, ['*'], 'old_ordinance_page')
            ->appends(array_merge($request->query(), ['tab' => 'old_ordinance']));

        return view('main.legislative_index', compact(
            'records',
            'oldRecords',
            'ordinances',
            'oldOrdinances',
            'activeTab'
        ));
    }
}
