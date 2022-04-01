<?php

namespace App\Admin\Controllers;

use App\Position;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PositionAdmin extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '餐车位置';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Position());

        $grid->column('id', __('ID'));
        $grid->column('location', __('地点'));
        $grid->column('longitude', __('经度'));
        $grid->column('latitude', __('纬度'));

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
        $show = new Show(Position::findOrFail($id));

        

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Position());

        $form->text('location', __('地点'));
        // $form->decimal('longitude', __('经度'));
        // $form->decimal('latitude', __('纬度'));
        $form->latlong('latitude', 'longitude', '坐标')->height(500)->default(['lat' => 39.908445, 'lng' => 116.397944]);;

        return $form;
    }
}
