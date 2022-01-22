<?php

namespace App\Admin\Actions;

use App\Http\Controllers\OrderCtrl;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Delivery extends RowAction
{
    public $name = '配送';

    public function handle(Model $model)
    {
        if ($model->status_id != 1 && $model->status_id != 2) {
            return $this->response()->error('状态错误')->refresh();
        }
        
        OrderCtrl::notify($model, 2);

        $model->update(['status_id' => 2]);
        return $this->response()->success('已更新状态')->refresh();
    }

}