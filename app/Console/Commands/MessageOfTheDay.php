<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\MessageStrategies\SundayStrategy;
use App\Console\Commands\MessageStrategies\MondayStrategy;
use App\Console\Commands\MessageStrategies\TuesdayStrategy;
use App\Console\Commands\MessageStrategies\WednesdayStrategy;
use App\Console\Commands\MessageStrategies\ThursdayStrategy;
use App\Console\Commands\MessageStrategies\FridayStrategy;
use App\Console\Commands\MessageStrategies\SaturdayStrategy;
use App\Contracts\MessageStrategyContract;

class MessageOfTheDay extends Command
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

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:message-of-the-day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $strategy = $this->getMessageStrategy();

        $this->info($strategy->getMessage());
    }

    protected function getMessageStrategy(): MessageStrategyContract
    {
        $date = today();

        $dayOfTheWeek = $date->dayName;

        return app($this->strategies[
            strtolower($dayOfTheWeek)
        ]);

    }
}
