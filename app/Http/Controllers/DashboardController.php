<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\Car;

use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard(){

        $today = date("Y-m-d");
        $today_car = Sale::select('car_id')
                            ->whereDate('date', $today)
                            ->where('status', 1)
                            ->groupBy('car_id')
                            ->orderByRaw("COUNT(*) DESC")
                            ->first();
        $today_number = Sale::selectRaw('COUNT(*) AS number')->whereDate('date', $today)->where('status', 1)->first();
        $today_total = Sale::selectRaw('SUM(car_price) AS total')->whereDate('date', $today)->where('status', 1)->first();

        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $yesterday_number = Sale::selectRaw('COUNT(*) AS number')->whereDate('date', $yesterday)->where('status', 1)->first();
        $yesterday_total = Sale::selectRaw('SUM(car_price) AS total')->whereDate('date', $yesterday)->where('status', 1)->first();

        $today_number_percentage = ($today_number->number - $yesterday_number->number) / $today_number->number * 100;
        $today_number_percentage_plus = $today_number_percentage > 0 ? "+" : "";
        $today_total_percentage = ($today_total->total - $yesterday_total->total) / $today_total->total * 100;
        $today_total_percentage_plus = $today_total_percentage > 0 ? "+" : "";


        $seven = Carbon::now()->subDays(7)->format("Y-m-d");
        $seven_car = Sale::select('car_id')
                            ->where(function($query) use ($today, $seven) {
                                $query->whereDate('date', '>=', $seven)
                                    ->whereDate('date', '<=', $today);
                            })
                            ->where('status', 1)
                            ->groupBy('car_id')
                            ->orderByRaw("COUNT(*) DESC")
                            ->first();
        $seven_number = Sale::selectRaw('COUNT(*) AS number')
                                ->where(function($query) use ($today, $seven) {
                                    $query->whereDate('date', '>=', $seven)
                                        ->whereDate('date', '<=', $today);
                                })->where('status', 1)
                                ->first();

        $seven_total = Sale::selectRaw('SUM(car_price) AS total')
                                ->where(function($query) use ($today, $seven) {
                                    $query->whereDate('date', '>=', $seven)
                                        ->whereDate('date', '<=', $today);
                                })
                                ->where('status', 1)
                                ->first();

        return view('dashboard', [
            'today' => [
                'car' => $today_car->car->name,
                'number' => $today_number->number,
                'number_percentage' => $today_number_percentage_plus . toNumber($today_number_percentage, 2) . "%",
                'total' => $today_total->total,
                'total_percentage' => $today_total_percentage_plus . toNumber($today_total_percentage, 2) . "%",
            ],
            'seven' => [
                'car' => $seven_car->car->name,
                'number' => $seven_number->number,
                'total' => $seven_total->total,
            ],
        ]);
    }
}
