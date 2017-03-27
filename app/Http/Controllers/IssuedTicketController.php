<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class IssuedTicketController extends Controller
{
    public function getIndex(Request $request) {
        $issued_tickets = \App\IssuedTicket::getIssuedTickets($request);
        $counters = \App\IssuedTicket::getCounters($request);

        $pagination = clone($issued_tickets);
        $pagination = $pagination->toArray();
        unset($pagination['data']);
        $issued_tickets = $issued_tickets->getCollection()->all();

        return response()->json([
            'issued_tickets' => $issued_tickets,
            'pagination'     => $pagination,
            'counters'       => $counters
        ], 200);
    }

    public function deleteDestroy($id) {
       \DB::beginTransaction();
        $issued_ticket = \App\IssuedTicket::findOrFail($id);
        $issued_ticket->valid = config('define.valid.false');

        if(!$issued_ticket->save()) {
            \DB::rollBack();
            return response()->json([
                'message'  => trans('custom.errors.occurred')
            ], 400);
        } else {
            \DB::commit();
            return response()->json([
                'message'  => config('define.result.success')
            ], 200);
        }
    }

    public function postCreate(Request $request, $id) {
        \Validator::extend('greater_than', function($attribute, $value, $parameters, $validator) {
            $validator->addReplacer('greater_than', function($message, $attribute, $rule, $parameters){
                return str_replace([':num'], $parameters, $message);
            });
            if($value >= $parameters[0]) {
                return true;
            } else {
                return false;
            }
        });
        $validator = \Validator::make($request->all(), [
            'adult_num'  => 'required|numeric',
            'child_num'  => 'required|numeric',
            'issue_num'  => 'required|numeric|greater_than:1',
        ]);
        if($validator->fails()) {
            return response()->json([
                'message' => trans('custom.errors.validation'),
                'errors'  => $validator->errors()
            ],422);
        }
        $ticket = \App\Ticket::where('id', $id)->count();
        if($ticket == 0) {
            return response()->json([
                'message' => trans('custom.errors.occurred'),
                'errors'  => [
                    'ticket' => [trans('custom.errors.not_found')]
                ]
            ], 422);
        }

        \DB::beginTransaction();
        try {
            for ($i=1; $i <= $request->input('issue_num'); $i++) { 
                $receive_key = str_random(25);
                \App\IssuedTicket::create([
                    'type'        => 'campaign',
                    'receive_key' => $receive_key,
                    'ticket_id'   => $id,
                    'adult_num'   => $request->input('adult_num'),
                    'child_num'   => $request->input('child_num'),
                    'issued_date' => \Carbon\Carbon::now()
                ]);
            }

            \DB::commit();
            return response()->json([
                'message'  => config('define.result.success')
            ], 200);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'message'  => trans('custom.errors.occurred')
            ], 400);
        }
    }

}
