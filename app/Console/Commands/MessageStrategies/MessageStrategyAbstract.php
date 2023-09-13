<?php

namespace App\Console\Commands\MessageStrategies;

use App\Console\Commands\MessageStrategies\Concerns\HandlesSpecialDates;
use App\Contracts\MessageStrategyContract;
use Illuminate\Support\Str;

abstract class MessageStrategyAbstract implements MessageStrategyContract
{
    use HandlesSpecialDates;

    public string $baseMessage = "";
    protected $date;

    public function __construct($date = null)
    {
        $this->date = is_null($date) ? now() : $date;
    }

    public function getMessage(): string
    {
        $message = Str::of($this->baseMessage);

        $specialDateMessage = $this->checkForSpecialDate($this->date);

        if (! is_null($specialDateMessage)) {
            $message = $message
                ->append(" Hoje é uma Data especial: ")
                ->append($specialDateMessage);
        }

        return $message->__toString();
    }
}
