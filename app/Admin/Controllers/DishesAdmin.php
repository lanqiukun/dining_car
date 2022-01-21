<?php

namespace App\Admin\Controllers;

use App\Dishes;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DishesAdmin extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '菜品';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Dishes());

        $grid->column('id', __('ID'));
        $grid->column('title', __('名称'))->editable();
        // $grid->column('detail', __('详情'));
        // $grid->column('imgSrc', __('主图'));
        $grid->column('imgSrc', '主图')->gallery(['height' => 80, 'zooming' => true]);

        $grid->column('price', __('价格'));
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
        $show = new Show(Dishes::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('detail', __('Detail'));
        $show->field('imgSrc', __('ImgSrc'));
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
        $form = new Form(new Dishes());

        $form->text('title', __('名称'));
        // $form->text('detail', __('详情'));
        $form->simditor('detail', '详情');
        $form->currency('price', __('价格'))->symbol('￥');
        // $form->text('imgSrc', __('主图'));
        $form->image('imgSrc', '主图');

        return $form;
    }
}
