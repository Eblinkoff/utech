<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FieldsTableSeeder extends Seeder
{
    /**
     * Заполняем нашу таблицу данными на месяц вперёд
     *
     * @return void
     */
    public function run()
    {
		$date = new DateTime();
		for($i = -15;$i <= 15; $i++)
		{
			$x = $i + 16;
			DB::table('fields')->insert([
				'date' => $date->format("Y-m-d"),
				'value' => ($x*$x + $x + 2)
			]);
			$date->modify("+1 day");
		}
    }
}
