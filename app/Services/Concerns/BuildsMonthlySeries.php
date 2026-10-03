<?php

namespace App\Services\Concerns;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

trait BuildsMonthlySeries
{
    /**
     * Aggregate a query per month for the last N months, filling gaps with zero.
     *
     * @return array{labels: list<string>, values: list<float>}
     */
    protected function monthlySeries(Builder $query, string $dateColumn, string $aggregate = 'count(*)', int $months = 12): array
    {
        $start = CarbonImmutable::now()->startOfMonth()->subMonths($months - 1);

        $totals = (clone $query)
            ->where($dateColumn, '>=', $start)
            ->selectRaw($this->monthExpression($dateColumn).' as month, '.$aggregate.' as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $labels = [];
        $values = [];

        for ($i = 0; $i < $months; $i++) {
            $month = $start->addMonths($i);
            $labels[] = $month->locale('ar')->translatedFormat('F');
            $values[] = round((float) ($totals[$month->format('Y-m')] ?? 0), 2);
        }

        return ['labels' => $labels, 'values' => $values];
    }

    protected function monthExpression(string $column): string
    {
        return match (DB::connection()->getDriverName()) {
            'sqlite' => "strftime('%Y-%m', {$column})",
            'pgsql' => "to_char({$column}, 'YYYY-MM')",
            default => "DATE_FORMAT({$column}, '%Y-%m')",
        };
    }

    /**
     * Percentage change between two values, rounded to one decimal.
     */
    protected function percentageChange(float $current, float $previous): float
    {
        if ($previous == 0.0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return round(($current - $previous) / $previous * 100, 1);
    }
}
