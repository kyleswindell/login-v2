<?php

/*
|--------------------------------------------------------------------------
| File: Modules/ProfileMfgPoc/Http/Controllers/ProfileMfgPocController.php
| Purpose: Renders the read-only Profile Mfg POC pages from a private snapshot.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\ProfileMfgPoc\Http\Controllers;

use App\Modules\ProfileMfgPoc\Exceptions\DatasetUnavailable;
use App\Modules\ProfileMfgPoc\Services\Dataset;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class ProfileMfgPocController
{
    public function __construct(
        private readonly Dataset $dataset,
    ) {}

    public function dashboard(): View|Response
    {
        return $this->render(fn (array $data): View => view('profile-mfg-poc::dashboard', $data));
    }

    public function customers(): View|Response
    {
        return $this->render(fn (array $data): View => view('profile-mfg-poc::customers.index', $data));
    }

    public function customer(string $customer): View|Response
    {
        return $this->render(function (array $data) use ($customer): View {
            abort_unless(isset($data['customers_by_id'][$customer]), 404);

            return view('profile-mfg-poc::customers.show', [
                ...$data,
                'customer' => $data['customers_by_id'][$customer],
            ]);
        });
    }

    public function parts(): View|Response
    {
        return $this->render(fn (array $data): View => view('profile-mfg-poc::parts.index', $data));
    }

    public function part(string $part): View|Response
    {
        return $this->render(function (array $data) use ($part): View {
            abort_unless(isset($data['parts_by_id'][$part]), 404);

            return view('profile-mfg-poc::parts.show', [
                ...$data,
                'part' => $data['parts_by_id'][$part],
            ]);
        });
    }

    public function orders(): View|Response
    {
        return $this->render(fn (array $data): View => view('profile-mfg-poc::orders.index', $data));
    }

    public function order(string $order): View|Response
    {
        return $this->render(function (array $data) use ($order): View {
            abort_unless(isset($data['orders_by_id'][$order]), 404);

            $orderRecord = $data['orders_by_id'][$order];

            return view('profile-mfg-poc::orders.show', [
                ...$data,
                'order' => $orderRecord,
                'customer' => $data['customers_by_id'][$orderRecord['customer_id']],
                'part' => $data['parts_by_id'][$orderRecord['part_id']],
            ]);
        });
    }

    public function inventory(): View|Response
    {
        return $this->render(fn (array $data): View => view('profile-mfg-poc::inventory.index', $data));
    }

    public function scanning(): View|Response
    {
        return $this->render(fn (array $data): View => view('profile-mfg-poc::scanning.index', $data));
    }

    public function reports(): View|Response
    {
        return $this->render(fn (array $data): View => view('profile-mfg-poc::reports.index', $data));
    }

    public function settings(): View|Response
    {
        return $this->render(fn (array $data): View => view('profile-mfg-poc::settings.index', $data));
    }

    public function partImage(string $part): BinaryFileResponse|Response
    {
        abort_unless((bool) config('profile-mfg-poc.enabled', false), 404);

        try {
            $data = $this->dataset->load();
            abort_unless(isset($data['parts_by_id'][$part]), 404);

            $imagePath = $this->dataset->imagePathFor($data['parts_by_id'][$part]);
            abort_unless(is_string($imagePath), 404);

            return response()->file($imagePath, [
                'Cache-Control' => 'private, no-store',
                'X-Content-Type-Options' => 'nosniff',
            ]);
        } catch (DatasetUnavailable) {
            return response('', 503);
        }
    }

    /**
     * @param  callable(array<string, mixed>): View  $page
     */
    private function render(callable $page): View|Response
    {
        abort_unless((bool) config('profile-mfg-poc.enabled', false), 404);

        try {
            return $page($this->dataset->load());
        } catch (DatasetUnavailable) {
            return response()->view('profile-mfg-poc::unavailable', [], 503);
        }
    }
}
