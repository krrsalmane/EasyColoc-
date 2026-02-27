<?php

namespace App\Services;

use App\Models\Colocation;

class BalanceService
{
    public function calculate(Colocation $colocation): array
    {
        // Get active members
        $members = $colocation->members()->wherePivotNull('left_at')->get();
        $count   = $members->count();

        if ($count === 0) return ['balances' => [], 'settlements' => []];

        $totalExpenses = $colocation->expenses()->sum('amount');
        $share         = $totalExpenses / $count;

        // Calculate each member's balance
        $balances = [];
        foreach ($members as $member) {
            $paid              = $colocation->expenses()->where('user_id', $member->id)->sum('amount');
            $balances[$member->id] = [
                'user'    => $member,
                'paid'    => $paid,
                'share'   => $share,
                'balance' => round($paid - $share, 2),
            ];
        }

        // Calculate who owes whom
        $settlements = $this->simplifyDebts($balances);

        return ['balances' => $balances, 'settlements' => $settlements];
    }

    private function simplifyDebts(array $balances): array
    {
        $debtors   = array_filter($balances, fn($b) => $b['balance'] < 0);
        $creditors = array_filter($balances, fn($b) => $b['balance'] > 0);
        $settlements = [];

        foreach ($debtors as $debtorId => $debtor) {
            $remaining = abs($debtor['balance']);

            foreach ($creditors as $creditorId => $creditor) {
                if ($remaining <= 0) break;
                if ($creditor['balance'] <= 0) continue;

                $amount = min($remaining, $creditor['balance']);
                $settlements[] = [
                    'from'   => $debtor['user'],
                    'to'     => $creditor['user'],
                    'amount' => round($amount, 2),
                ];

                $remaining -= $amount;
                $creditors[$creditorId]['balance'] -= $amount;
            }
        }

        return $settlements;
    }
}