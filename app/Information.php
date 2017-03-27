<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\ValidScope;

class Information extends Model
{
    protected $table = 'informations';

    protected $fillable = ['comments_ja','comments_en','open_date','close_date','valid'];

    /**
     * The "booting" method of the model.
     * for getting only valid => true
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ValidScope);
    }

    static function getInformations($request) {
        $offset = 15;
        $latest = 6;
        $dt = \Carbon\Carbon::now();

        if($request->has('offset')) {
            $offset = $request->input('offset');
        }

        if($request->has('latest')) {
            $infos = parent::where('open_date','<=',$dt)
                ->where('close_date','>=',$dt);

            $latest = $request->input('latest');
            $infos->orderBy('created_at','desc');
            $infos->take($latest);
           return $infos->get(['id','comments_'.\App::getLocale().' as comments','open_date']);
        } else {
            $infos = parent::select(['id','comments_'.\App::getLocale().' as comments', 'open_date','close_date'])->orderBy('id','desc');
            if($request->has('search')) {
                $like = $request->input('search');
                $infos->where('comments_'.\App::getLocale(), 'LIKE', "%$like%");
            }
            return $infos->paginate($offset);
        }
    }

    static function getInformation($id) {
        $info = parent::where('id', $id)->first(['id','comments_en', 'comments_ja','open_date', 'close_date']);
        return $info;
    }

}
