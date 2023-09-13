<?php

namespace Tests\Feature;

use App\Console\Commands\MessageStrategies\FridayStrategy;
use App\Console\Commands\MessageStrategies\MondayStrategy;
use App\Console\Commands\MessageStrategies\SaturdayStrategy;
use App\Console\Commands\MessageStrategies\SundayStrategy;
use App\Console\Commands\MessageStrategies\ThursdayStrategy;
use App\Console\Commands\MessageStrategies\TuesdayStrategy;
use App\Console\Commands\MessageStrategies\WednesdayStrategy;
use Tests\TestCase;

class MessageOfTheDayTest extends TestCase
{
    protected $strategies = [
        'sunday' => SundayStrategy::class,
        'monday' => MondayStrategy::class,
        'tuesday' => TuesdayStrategy::class,
        'wednesday' => WednesdayStrategy::class,
        'thursday' => ThursdayStrategy::class,
        'friday' => FridayStrategy::class,
        'saturday' => SaturdayStrategy::class,
    ];

    public function testItRunsSuccessfully(): void
    {
        $this->artisan("app:message-of-the-day")
            ->assertSuccessful();
    }

    public function testItRunsSuccesfullyEveryDayOfTheWeek()
    {
        for ($i = 0; $i < 7; $i++) {
            $date = now()->setDaysFromStartOfWeek($i);

            $this->travelTo($date);

            $strategy = app($this->strategies[strtolower($date->dayName)]);

            $this->artisan("app:message-of-the-day")
                 ->assertSuccessful()
                 ->expectsOutputToContain($strategy->getMessage());

            $this->travelBack();
        }
    }

    public function testItHandlesSpecialDates()
    {
        $date = now()->setDate(now()->year, 12, 25);

        $this->travelTo($date);

        $strategy = app($this->strategies[strtolower($date->dayName)]);

        $this->artisan("app:message-of-the-day")
             ->assertSuccessful()
             ->expectsOutputToContain($strategy->getMessage());

        $this->travelBack();
    }
}
