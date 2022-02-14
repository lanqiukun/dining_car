<?php

namespace App\Admin\Actions;

use App\Http\Controllers\OrderCtrl;
use App\Http\Controllers\WechatCtrl;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Drop extends RowAction
{
    public $name = '投递';

    public function handle(Model $model)
    {
        // if ($model->status_id != 2 && $model->status_id != 3) {
        //     return $this->response()->error('状态错误')->refresh();
        // }
        
        WechatCtrl::notify($model, 3);

        $model->update(['status_id' => 3]);
        return $this->response()->success('已更新状态')->refresh();
    }

}