<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PublicHoliday;
use Carbon\Carbon;

class PublicHolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $year = Carbon::now()->year;

        $holidays = [
            [
                'name' => 'Tahun Baru Masehi',
                'holiday_date' => Carbon::create($year, 1, 1)->toDateString(),
            ],
            [
                'name' => 'Hari Buruh Internasional',
                'holiday_date' => Carbon::create($year, 5, 1)->toDateString(),
            ],
            [
                'name' => 'Hari Kemerdekaan Republik Indonesia',
                'holiday_date' => Carbon::create($year, 8, 17)->toDateString(),
            ],
            [
                'name' => 'Hari Raya Natal',
                'holiday_date' => Carbon::create($year, 12, 25)->toDateString(),
            ],
            [
                'name' => 'Hari Raya Idul Fitri 1445 H (Hari Pertama)',
                'holiday_date' => '2024-04-10',
            ],
            [
                'name' => 'Hari Raya Idul Fitri 1445 H (Hari Kedua)',
                'holiday_date' => '2024-04-11',
            ],
        ];

        foreach ($holidays as $holiday) {
            PublicHoliday::firstOrCreate(
                ['holiday_date' => $holiday['holiday_date']],
                ['name' => $holiday['name']]
            );
        }

        $this->command->info('Public holidays for ' . $year . ' have been seeded.');
    }
}
