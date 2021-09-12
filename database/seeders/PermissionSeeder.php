<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * categories permissions
         */

        Permission::query()->insert([
            [
                'title' => 'read-category',
                'lable' => 'مشاهده دسته بندی'
            ],
            [
                'title' => 'create-category',
                'lable' => 'ایجاد دسته بندی'
            ],
            [
                'title' => 'update-category',
                'lable' => 'ویرایش دسته بندی'
            ],
            [
                'title' => 'delete-category',
                'lable' => 'حذف دسته بندی'
            ],
        ]);


        /**
         * brands permissions
         */

        Permission::query()->insert([
            [
                'title' => 'read-brand',
                'lable' => 'مشاهده برند'
            ],
            [
                'title' => 'create-brand',
                'lable' => 'ایجاد برند'
            ],
            [
                'title' => 'update-brand',
                'lable' => 'ویرایش برند'
            ],
            [
                'title' => 'delete-brand',
                'lable' => 'حذف برند'
            ],
        ]);


        /**
         * products permissions
         */

        Permission::query()->insert([
            [
                'title' => 'read-product',
                'lable' => 'مشاهده محصول'
            ],
            [
                'title' => 'create-product',
                'lable' => 'ایجاد محصول'
            ],
            [
                'title' => 'update-product',
                'lable' => 'ویرایش محصول'
            ],
            [
                'title' => 'delete-product',
                'lable' => 'حذف محصول'
            ],
        ]);


        /**
         * discounts permissions
         */

        Permission::query()->insert([
            [
                'title' => 'read-discounts',
                'lable' => 'مشاهده تخفیف'
            ],
            [
                'title' => 'create-discounts',
                'lable' => 'ایجاد تخفیف'
            ],
            [
                'title' => 'update-discounts',
                'lable' => 'ویرایش تخفیف'
            ],
            [
                'title' => 'delete-discounts',
                'lable' => 'حذف تخفیف'
            ],
        ]);



        /**
         * pictures permissions
         */

        Permission::query()->insert([
            [
                'title' => 'read-picture',
                'lable' => 'مشاهده تصویر'
            ],
            [
                'title' => 'create-picture',
                'lable' => 'ایجاد تصویر'
            ],
            [
                'title' => 'update-picture',
                'lable' => 'ویرایش تصویر'
            ],
            [
                'title' => 'delete-picture',
                'lable' => 'حذف تصویر'
            ],
        ]);



        /**
         * offers permissions
         */

        Permission::query()->insert([
            [
                'title' => 'read-offer',
                'lable' => 'مشاهده کد تخفیف'
            ],
            [
                'title' => 'create-offer',
                'lable' => 'ایجاد کد تخفیف'
            ],
            [
                'title' => 'update-offer',
                'lable' => 'ویرایش کد تخفیف'
            ],
            [
                'title' => 'delete-offer',
                'lable' => 'حذف کد تخفیف'
            ],
        ]);



        /**
         * roles permissions
         */

        Permission::query()->insert([
            [
                'title' => 'read-role',
                'lable' => 'مشاهده نقش'
            ],
            [
                'title' => 'create-role',
                'lable' => 'ایجاد نقش'
            ],
            [
                'title' => 'update-role',
                'lable' => 'ویرایش نقش'
            ],
            [
                'title' => 'delete-role',
                'lable' => 'حذف نقش'
            ],
        ]);


        /**
         * dashboard permissions
         */

        Permission::query()->insert([
            [
                'title' => 'view-dashboard',
                'label' => 'مشاهده داشبورد',
            ]

        ]);


    }
}
