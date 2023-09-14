<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //=================احصائية نسبة تنفيذ الحالات======================



        $TotalCount = Invoices::count();
        $paidCount = Invoices::where('Value_Status', '1')->count();
        $unPaidCount = Invoices::where('Value_Status', '2')->count();
        $partialCount = Invoices::where('Value_Status', '3')->count();

      if($unPaidCount == 0){
          $unPaidPercent=0;
      }
      else{
        $unPaidPercent = round(($unPaidCount / $TotalCount) * 100);
      }

        if($paidCount == 0){
            $paidPercent=0;
        }
        else{
            $paidPercent = round(($paidCount / $TotalCount) * 100);
        }

        if($partialCount == 0){
            $partialPercent=0;
        }
        else{
            $partialPercent = round(($partialCount / $TotalCount) * 100);
        }
        // ==================================================
        $chartjs = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        // ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
        ->datasets([
            [
                "label" => "الفواتير الغير المدفوعة",
                'backgroundColor' => ['#ec5858'],
                'data' => [$unPaidPercent]
            ],
            [
                "label" => "الفواتير المدفوعة",
                'backgroundColor' => ['#81b214'],
                'data' => [$paidPercent]
            ],
            [
                "label" => "الفواتير المدفوعة جزئيا",
                'backgroundColor' => ['#ff9642'],
                'data' => [$partialPercent]
            ],


        ])
        ->options([]);
    // ===========================================
    $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 350, 'height' => 250])
            ->labels(['الغير المدفوعة', 'المدفوعة','المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                    'data' => [$unPaidPercent, $paidPercent,$partialPercent]
                ]
            ])
            ->options([]);

        return view('home', compact('paidPercent', 'unPaidPercent', 'partialPercent', 'chartjs','chartjs_2'));
    }
}
