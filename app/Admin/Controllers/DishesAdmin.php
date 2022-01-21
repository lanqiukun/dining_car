<?php

namespace App\Admin\Controllers;

use App\Category;
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
        $grid->column('imgurl', '主图')->gallery(['height' => 80, 'zooming' => true]);

        $categories = Category::pluck('title', 'id')->toArray();


        $grid->column('category_id', '分类')->editable('select', $categories);;


        $grid->column('price', __('价格'));
        $grid->column('sales', __('销量'))->editable();
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
        $show->field('imgurl', __('imgurl'));
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
        $form->image('imgurl', '主图');
        $form->number('sales', __('销量'))->default(0);

        $categories = Category::pluck('title', 'id')->toArray();

        $form->select('category_id', '分类')->options($categories);

        return $form;
    }
}
