<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SaleController extends Controller
{
    public function getIndex(Request $request) {
        $temp_summary = array();
        $summary = array();

        $sales = \App\Payment::getSalesSummary($request);
        foreach($sales as $key => $sale) {
            if($sale->type == 'charge') {
                $temp_summary[$sale->ticket_id]['name']                  = $sale->name;
                $temp_summary[$sale->ticket_id]['adult_sales_num'][]     = $sale->adult_num;
                $temp_summary[$sale->ticket_id]['child_sales_num'][]     = $sale->child_num;
                $temp_summary[$sale->ticket_id]['adult_sales_amount']    = $sale->adult_price;
                $temp_summary[$sale->ticket_id]['child_sales_amount']    = $sale->child_price;
                $temp_summary[$sale->ticket_id]['adult_cancel_num'][]    = 0;
                $temp_summary[$sale->ticket_id]['child_cancel_num'][]    = 0;
                $temp_summary[$sale->ticket_id]['adult_cancel_amount']   = $sale->adult_price;
                $temp_summary[$sale->ticket_id]['child_cancel_amount']   = $sale->child_price;
           } else if($sale->type == 'refund') {
                $temp_summary[$sale->ticket_id]['adult_cancel_num'][]    = $sale->adult_num;
                $temp_summary[$sale->ticket_id]['child_cancel_num'][]    = $sale->child_num;
                $temp_summary[$sale->ticket_id]['adult_cancel_amount']   = $sale->adult_price;
                $temp_summary[$sale->ticket_id]['child_cancel_amount']   = $sale->child_price;
           }
        }

        foreach ($temp_summary as $ticket_id => $num) {
            $summary[$ticket_id]['ticket_id']           = $ticket_id;
            $summary[$ticket_id]['name']                = $num['name'];
            $summary[$ticket_id]['adult_sales_num']     = array_sum($num['adult_sales_num']);
            $summary[$ticket_id]['child_sales_num']     = array_sum($num['child_sales_num']);
            $summary[$ticket_id]['adult_sales_amount']  = array_sum($num['adult_sales_num']) * $num['adult_sales_amount'];
            $summary[$ticket_id]['child_sales_amount']  = array_sum($num['child_sales_num']) * $num['child_sales_amount'];
            $summary[$ticket_id]['adult_cancel_num']    = array_sum($num['adult_cancel_num']);
            $summary[$ticket_id]['child_cancel_num']    = array_sum($num['child_cancel_num']);
            $summary[$ticket_id]['adult_cancel_amount'] = array_sum($num['adult_cancel_num']) * $num['adult_cancel_amount'];
            $summary[$ticket_id]['child_cancel_amount'] = array_sum($num['child_cancel_num']) * $num['child_cancel_amount'];
            $summary[$ticket_id]['total_amount']        = ( (array_sum($num['adult_sales_num']) * $num['adult_sales_amount']) + (array_sum($num['child_sales_num']) * $num['child_sales_amount']) ) - ( array_sum($num['adult_cancel_num']) * $num['adult_cancel_amount'] + array_sum($num['child_cancel_num']) * $num['child_cancel_amount']);
        }

        return response()->json([
            'sales_summaries' => (array)((object)$summary)
        ], 200);
    }
    //
}
