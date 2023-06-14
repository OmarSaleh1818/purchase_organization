<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permissions = [

            'طلب مواد',
            'المشتريات',
            'طلب شراء',
            'طلب اصدار دفعة',
            'المحاسبة',
            'الادارة المالية',
            'المدير العام',
            'الخزنة',
            'الشركات',
            'المستخدمين',
            'قائمة المستخدمين',
            'صلاحيات المستخدمين',
        ];



        foreach ($permissions as $permission) {

            Permission::create(['name' => $permission]);
        }

    }
}
