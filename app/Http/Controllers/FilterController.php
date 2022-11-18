<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Resources\EventResource;
use Carbon\Carbon;

class FilterController extends Controller
{
    public function filter(Request $request)
    {
        $query = Event::query();
        switch($request->selected)
        {
            case "1":
                $events = $query->where('end_date', '<', date('Y-m-d'))->get();
                break;
            case 2:
                $events = $query->where('start_date', '>', date('Y-m-d'))->get();
                break;
            case "3":
                $events = $query->where('start_date', '>', date('Y-m-d'))->where('start_date', '<', Carbon::today()->addDays(7))->get();
                break;
            case "4":
                $events = $query->where('end_date', '<', date('Y-m-d'))->where('end_date', '>', Carbon::now()->subDays(7))->get();
                break;
            default:
                $events = $query->orderBy('start_date')->get();
        }

        return response()->json(EventResource::collection($events));
    }
}
