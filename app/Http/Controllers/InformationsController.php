<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Information;

class InformationsController extends Controller
{
    /** 
     * @var Item
     */
    protected $information;

    /** 
     * @param Information $information
     */
    public function __construct(Information $information)
    {   
        $this->information = $information;
    }

    protected function getIndex(Request $request) {
        $pagination = array();
        $infos      = Information::getInformations($request);

        if(!$request->has('latest')) {
            $pagination = clone($infos);
            $pagination = $pagination->toArray();
            unset($pagination['data']);
            $infos = $infos->getCollection()->all();
        }
        return response()->json([
            'informations' => $infos,
            'pagination'   => $pagination
        ],200);
    }

    protected function postCreate(Request $request) {
        $validator = \Validator::make($request->all(), [
            'comment_en'    => 'required|max:255',
            'comment_ja'    => 'required|max:255',
            'open_date'     => 'required|date_format:"Y-m-d H:i:s"',
            'close_date'    => 'required|date_format:"Y-m-d H:i:s"',
        ]);
        if($validator->fails()) {
            return response()->json([
                'message' => trans('custom.errors.validation'),
                'errors'  => $validator->errors()
            ],422);
        }
        \DB::beginTransaction();
        $information = Information::create([
            'comments_en' => $request->input('comment_en'),
            'comments_ja' => $request->input('comment_ja'),
            'open_date' => $request->input('open_date'),
            'close_date' => $request->input('close_date')
        ]);

        if(!$information) {
            \DB::rollBack();
            return response()->json([
                'message' => trans('custom.errors.occurred'),
                'errors'  => [
                    'information' => [config('define.result.failure')]
                ]
            ], 422);
        } else {
            \DB::commit();
            return response()->json([
                'message'  => config('define.result.success')
            ], 200);
        }
    }

    protected function getEdit($id) {
        $information = Information::getInformation($id);
        if(empty($information)) {
            return response()->json('',204);
        }
        return  response()->json([
            'information' => $information
        ], 200);
    }

    protected function putEdit(Request $request, $id) {
        $validator = \Validator::make($request->all(), [
            'comment_en' => 'required|max:255',
            'comment_ja' => 'required|max:255',
            'open_date' => 'required|date_format:"Y-m-d H:i:s"',
            'close_date' => 'required|date_format:"Y-m-d H:i:s"'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => trans('custom.errors.validation'),
                'errors'  => $validator->errors()
            ], 422);
        }

        \DB::beginTransaction();
        $information = Information::where('id',$id)->update([
            'comments_en' => $request->input('comment_en'),
            'comments_ja' => $request->input('comment_ja'),
            'open_date' => $request->input('open_date'),
            'close_date' => $request->input('close_date')
        ]);

        if(!$information) {
            \DB::rollBack();
            return response()->json([
                'message' => trans('custom.errors.occurred'),
                'errors'  => [
                    'information' => [config('define.result.failure')]
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
        $information = Information::findOrFail($id);
        $information->valid = config('define.valid.false');

        if(!$information->save()) {
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
