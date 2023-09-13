<?php

namespace App\Console\Commands\MessageStrategies\Concerns;

use Illuminate\Support\Carbon;

trait HandlesSpecialDates
{
    protected array $specialDates = [
        "01-01" => "Dia da Confraternização Universal",
        "04-21" => "Dia de Tiradentes",
        "05-01" => "Dia do Trabalho",
        "05-01" => "Dia do Trabalho",
        "06-08" => "Corpus Christi",
        "09-07" => "Dia da Independência do Brasil",
        "10-12" => "Dia de Nossa Senhora Aparecida",
        "11-02" => "Dia de Finados",
        "12-25" => "Natal",
    ];

    public function checkForSpecialDate(Carbon $date): ?string
    {
        $month = $date->month;
        $day = $date->day;

        $key = "$month-$day";

        $specialDayName = array_key_exists($key, $this->specialDates) ? $this->specialDates[$key] : null;

        return $specialDayName;
    }

    public function getSpecialDates(): array
    {
        return $this->specialDates;
    }
}
