<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = array(
            [
                'name' => 'Cash',
                'number' => '001',
            ]
            // [
            //     'name' => 'Mpesa',
            //     'number' => '002',
            // ],
            // [
            //     'name' => 'Bank',
            //     'number' => '003',
            // ],
            // [
            //     'name' => 'OpenFloat PesaPal',
            //     'number' => '003',
            // ],
            // [
            //     'name' => 'Cheque',
            //     'number' => '004',
            // ]
        );
        foreach ($accounts as $account) {
            \App\Models\Account::create($account);
        }
    }
}
