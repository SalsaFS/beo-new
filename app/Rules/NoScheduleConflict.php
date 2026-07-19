<?php

namespace App\Rules;

use App\Models\BeoFunction;
use App\Models\BeoFunctionPackage;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoScheduleConflict implements ValidationRule
{
    public function __construct(protected Closure $data) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $raw = ($this->data)();

        if (! is_array($raw)) {
            return;
        }

        $data = $raw['data'] ?? $raw;

        if (! preg_match('/^data\.(beoFunctions|beoFunctionPackages)\.(\d+)\.time_end$/', $attribute, $m)) {
            return;
        }

        $group = $m[1];
        $idx = (int) $m[2];

        $date = $data['date_of_function'] ?? null;
        $venue = $data[$group][$idx]['venue_id'] ?? null;
        $start = $data[$group][$idx]['time_start'] ?? null;
        $end = $value;

        if (blank($date) || blank($venue) || blank($start) || blank($end)) {
            return;
        }

        $formIds = [];

        foreach (['beoFunctions', 'beoFunctionPackages'] as $g) {
            foreach (($data[$g] ?? []) as $item) {
                if (isset($item['id'])) {
                    $formIds[$g][] = $item['id'];
                }
            }
        }

        $db1 = BeoFunction::query()
            ->join('beos', 'beos.id', '=', 'beo_functions.beo_id')
            ->where('beos.date_of_function', $date)
            ->where('beo_functions.venue_id', $venue)
            ->where('beo_functions.time_start', '<', $end)
            ->where('beo_functions.time_end', '>', $start);

        if (! empty($formIds['beoFunctions'])) {
            $db1->whereNotIn('beo_functions.id', $formIds['beoFunctions']);
        }

        if ($db1->exists()) {
            $fail('Schedule not available.');

            return;
        }

        $db2 = BeoFunctionPackage::query()
            ->join('beos', 'beos.id', '=', 'beo_function_packages.beo_id')
            ->where('beos.date_of_function', $date)
            ->where('beo_function_packages.venue_id', $venue)
            ->where('beo_function_packages.time_start', '<', $end)
            ->where('beo_function_packages.time_end', '>', $start);

        if (! empty($formIds['beoFunctionPackages'])) {
            $db2->whereNotIn('beo_function_packages.id', $formIds['beoFunctionPackages']);
        }

        if ($db2->exists()) {
            $fail('Schedule not available.');
        }
    }
}
