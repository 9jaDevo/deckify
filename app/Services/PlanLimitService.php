<?php

namespace App\Services;

use App\Models\User;
use Carbon\CarbonImmutable;

class PlanLimitService
{
    public function limitFor(User $user): int
    {
        $plan = $this->normalizedPlan($user);
        /** @var array<string, int> $limits */
        $limits = config('deckify.plan_limits', []);

        return (int) ($limits[$plan] ?? ($limits['free'] ?? 5));
    }

    public function usageForCurrentMonth(User $user): int
    {
        [$start, $end] = $this->currentMonthWindow();

        return $user->generations()
            ->whereBetween('created_at', [$start, $end])
            ->count();
    }

    public function remainingForCurrentMonth(User $user): int
    {
        return max(0, $this->limitFor($user) - $this->usageForCurrentMonth($user));
    }

    public function hasReachedLimit(User $user): bool
    {
        return $this->usageForCurrentMonth($user) >= $this->limitFor($user);
    }

    /**
     * @return array{0: CarbonImmutable, 1: CarbonImmutable}
     */
    private function currentMonthWindow(): array
    {
        $start = CarbonImmutable::now()->startOfMonth();
        $end = CarbonImmutable::now()->endOfMonth();

        return [$start, $end];
    }

    private function normalizedPlan(User $user): string
    {
        $plan = strtolower(trim((string) ($user->plan ?? 'free')));

        return in_array($plan, ['free', 'pro', 'team'], true) ? $plan : 'free';
    }
}
