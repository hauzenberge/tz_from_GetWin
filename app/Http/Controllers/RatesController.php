<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rates;

class RatesController extends Controller
{
    public function index()
    {
        return view('rates', [
            'rates' => [],
            'date_from_filter' => '',
            'massege' => null
        ]);
    }

    public function add(Request $request)
    {
        $validation = $request->validate([
            'date' => ['required', 'date_format:Y-m-d'],
            'rate' => ['required', 'numeric']
        ]);
        Rates::create([
            'date' => $validation['date'],
            'rate' => $validation['rate']
        ]);
        return redirect('/');
    }

    public function filter(Request $request)
    {
        $rates = Rates::where('date', $request->input('date'))->get();
        if ($rates->count() == 0) {
            $massege = 'Курси по цій даті не знайденію';
        }else $massege = null;
        $pie_data = $rates
            ->map(function ($item) {
                return $item->rate;
            })
            ->values()
            ->toArray();
        $pie_lables = $rates
            ->map(function ($item) use ($request) {
                return $request->input('date');
            })
            ->values()
            ->toArray();
        return view('rates', [
            'rates' => $rates->toArray(),
            'date_from_filter' => $request->input('date'),
            'pie_lables' => $pie_lables,
            'pie_data' => $pie_data,
            'massege' => $massege
        ]);
    }
}
