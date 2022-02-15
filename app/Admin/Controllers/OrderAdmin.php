<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Delivery;
use App\Admin\Actions\Drop;
use App\Order;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

class OrderAdmin extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '订单';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order());

        $grid->actions(function ($actions) {
            // $actions->add(new Delivery);
            $actions->add(new Drop);
        });

        $grid->column('id', __('ID'));
        
        $grid->column('order_no', '订单号')->expand(function ($model) {

            $dishes = array_map(function($e){
                return [
                    'id' => $e["id"],
                    'title' => $e["title"],
                    'price' => $e["price"],
                    'amount' => $e["pivot"]["amount"],
                ];
            }, $model->dishes->toArray());

           return new Table(['ID', '标题', '价格', '数量'], $dishes);
        })->copyable();
        
        $grid->column('user.nickname', __('用户'));
        $grid->column('lunch_box', __('归还餐具'));
        $grid->column('cost', __('订单金额'));


        // $grid->column('dishes.imgurl', '主图')->gallery(['height' => 80, 'zooming' => true]);

        // $grid->column('amount', __('数量'))->display(function($amount) {
        //     return $amount . '份';
        // });

        // $grid->column('price', __('价格'));
        $grid->column('position.location', __('配送地点'));
        $grid->column('status.description', __('状态'));
        $grid->column('created_at', __('创建时间'));
        // $grid->column('updated_at', __('Updated at'));

        $grid->model()->orderBy('id', 'desc');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Order::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('user_id', __('User id'));
        $show->field('price', __('Price'));
        $show->field('status', __('Status'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Order());

        $form->number('user_id', __('User id'));
        $form->decimal('price', __('Price'));
        $form->switch('status', __('Status'));

        return $form;
    }
}
