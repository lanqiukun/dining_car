<?php

namespace App\Admin\Controllers;

use App\Order;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

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

        $grid->column('id', __('ID'));
        $grid->column('user.nickname', __('用户'));
        $grid->column('dishes.title', __('菜品'));
        $grid->column('dishes.imgSrc', '主图')->gallery(['height' => 80, 'zooming' => true]);

        // $grid->column('price', __('价格'));
        $grid->column('status', __('状态'))->using([
            0 => ' 已下单',
            1 => ' 等待配送',
            2 => ' 等待取餐',
            3 => ' 取餐完成',
            4 => ' 已评价',
        ]);
        $grid->column('created_at', __('创建时间'));
        // $grid->column('updated_at', __('Updated at'));

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
