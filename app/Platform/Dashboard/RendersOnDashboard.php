<?php

namespace App\Platform\Dashboard;

interface RendersOnDashboard
{
    public function getDashboardView(): string;

    /**
     * @return array<string, mixed>
     */
    public function getDashboardViewData(): array;
}
