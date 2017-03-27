<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ticket;

class TicketsController extends Controller
{

    /** 
     * @var Item
     */
    protected $ticket;

    /** 
     * @param Ticket $user
     */
    public function __construct(Ticket $ticket)
    {   
        $this->ticket = $ticket;
    }
    //
    public function getIndex(Request $request)
    {   
        $filter = [];
        $pagination = array();

        if($request->has('recommended')){
            $filter['recommended'] = $request->input('recommended');
        }
        if($request->has('purchasable')){
            $filter['purchasable'] = $request->input('purchasable');
        }
        if($request->has('admin') && $request->input('admin') == config('define.valid.true')) {
            $tickets = $this->ticket->getAdminTickets($request);
            $pagination = clone($tickets);
            $pagination = $pagination->toArray();
            unset($pagination['data']);
            $tickets = $tickets->getCollection()->all();
        } else {
            $tickets = $this->ticket->getTickets($filter);
        }
        return response()->json([
            'tickets' => $tickets,
            'pagination' => $pagination
        ], 200);
    }

    public function getShow($id) {
        $ticket = $this->ticket->getTicket($id);
        if(empty($ticket)){
            return response()->json("",204);
        }
        return response()->json([
            'ticket' => $ticket
        ], 200);
    }

    protected function getEdit($id) {
        $ticket = Ticket::find($id);
        if(empty($ticket)) {
            return response()->json('',204);
        }
        return  response()->json([
            'ticket' => $ticket
        ], 200);
    }

    protected function putEdit(Request $request, $id) {
        $validator = \Validator::make($request->all(), [
            'name_en'    => 'required|max:255',
            'name_ja'    => 'required|max:255',
            'description_en'    => 'required',
            'description_ja'    => 'required',
            'color'      => 'required',
            'adult_price'=> 'numeric',
            'child_price'=> 'numeric',
            'type'       => 'required',
            'duration'   => 'required|numeric'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => trans('custom.errors.validation'),
                'errors'  => $validator->errors()
            ], 422);
        }
        \DB::beginTransaction();
        $ticket = Ticket::find($id);

        $ticket->name_en     = $request->input('name_en');
        $ticket->name_ja     = $request->input('name_ja');
        $ticket->description_en    = $request->input('description_en');
        $ticket->description_ja    = $request->input('description_ja');
        $ticket->color       = $request->input('color');
        $ticket->adult_price = ($request->input('adult_price') == 0 || is_null($request->input('adult_price')))?NULL:$request->input('adult_price');
        $ticket->child_price = ($request->input('child_price') == 0 || is_null($request->input('child_price')))?NULL:$request->input('child_price');
        $ticket->type        = $request->input('type');
        $ticket->duration    = $request->input('duration');
        if($request->has('recommended')) {
            $ticket->recommended = $request->input('recommended');
        } else {
            $ticket->recommended = false;
        }
        if($request->has('file')) {
            $ticket->image_url = env('WEB_URL').$request->input('file');
        }

        if(!$ticket->save()) {
            \DB::rollBack();
            return response()->json([
                'message' => trans('custom.errors.occurred'),
                'errors'  => [
                    'ticket' => [config('define.result.failure')]
                ]
            ], 422);
        } else {
            \DB::commit();
            return response()->json([
                'message'  => config('define.result.success')
            ], 200);
        }
    }

    protected function postCreate(Request $request) {
        $validator = \Validator::make($request->all(), [
            'name_en'    => 'required|max:255',
            'name_ja'    => 'required|max:255',
            'description_en'    => 'required',
            'description_ja'    => 'required',
            'color'      => 'required',
            'adult_price'=> 'numeric',
            'child_price'=> 'numeric',
            'type'=> 'required',
            'duration'=> 'required|numeric',
        ]);
        if($validator->fails()) {
            return response()->json([
                'message' => trans('custom.errors.validation'),
                'errors'  => $validator->errors()
            ],422);
        }
        \DB::beginTransaction();
        $ticket = new Ticket;

        $ticket->name_en     = $request->input('name_en');
        $ticket->name_ja     = $request->input('name_ja');
        $ticket->description_en    = $request->input('description_en');
        $ticket->description_ja    = $request->input('description_ja');
        $ticket->color       = $request->input('color');
        $ticket->adult_price = ($request->input('adult_price') == 0 || is_null($request->input('adult_price')))?NULL:$request->input('adult_price');
        $ticket->child_price = ($request->input('child_price') == 0 || is_null($request->input('child_price')))?NULL:$request->input('child_price');
        $ticket->type        = $request->input('type');
        $ticket->duration    = $request->input('duration');
        if($request->has('recommended')) {
            $ticket->recommended = $request->input('recommended');
        }
        if($request->has('file')) {
            $ticket->image_url = env('WEB_URL').$request->input('file');
        }

        if(!$ticket->save()) {
            \DB::rollBack();
            return response()->json([
                'message' => trans('custom.errors.occurred'),
                'errors'  => [
                    'ticket' => [config('define.result.failure')]
                ]
            ], 422);
        } else {
            \DB::commit();
            return response()->json([
                'message'  => config('define.result.success')
            ], 200);
        }
    }

    public function deleteDestroy($id) {
        \DB::beginTransaction();
        $ticket = Ticket::find($id);
        $ticket->valid = config('define.valid.false');

        if(!$ticket->save()) {
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

}
