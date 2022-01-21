<?php

namespace App\Admin\Controllers;

use App\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserAdmin extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('ID'));
        $grid->column('avatar', '头像')->gallery(['height' => 80, 'zooming' => true]);
        $grid->column('nickname', __('昵称'));
        $grid->column('openid', __('openid'));
        // $grid->column('avatar', __('头像'));
        // $grid->column('token', __('Token'));
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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('openid', __('Openid'));
        $show->field('nickname', __('Nickname'));
        $show->field('avatar', __('Avatar'));
        $show->field('token', __('Token'));
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
        $form = new Form(new User());

        $form->text('openid', __('Openid'));
        $form->text('nickname', __('Nickname'));
        $form->image('avatar', __('Avatar'));
        $form->text('token', __('Token'));

        return $form;
    }
}
