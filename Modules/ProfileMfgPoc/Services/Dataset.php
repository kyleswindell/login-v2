<?php

/*
|--------------------------------------------------------------------------
| File: Modules/ProfileMfgPoc/Services/Dataset.php
| Purpose: Validates and derives read-only Profile Mfg POC snapshot data.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\ProfileMfgPoc\Services;

use App\Modules\ProfileMfgPoc\Exceptions\DatasetUnavailable;
use DateTimeImmutable;
use Throwable;

final class Dataset
{
    private const CUSTOMER_STATUSES = ['active', 'obsolete'];

    private const PART_STATUSES = ['active', 'service', 'obsolete', 'purchase', 'wip'];

    private const ORDER_STATUSES = ['open', 'shorted', 'closed', 'cancelled'];

    private const OPEN_ORDER_STATUSES = ['open', 'shorted'];

    private const SCAN_DIRECTIONS = ['in', 'out'];

    private const SCAN_STATUSES = ['accepted', 'rejected'];

    private const IMAGE_MIME_TYPES = ['image/gif', 'image/jpeg', 'image/png', 'image/webp'];

    /**
     * @return array<string, mixed>
     */
    public function load(): array
    {
        try {
            $contents = @file_get_contents($this->path());

            if (! is_string($contents)) {
                throw new DatasetUnavailable;
            }

            $data = json_decode($contents, true, flags: JSON_THROW_ON_ERROR);

            if (! is_array($data)) {
                throw new DatasetUnavailable;
            }

            $this->validate($data);

            return $this->enrich($data);
        } catch (DatasetUnavailable $exception) {
            throw $exception;
        } catch (Throwable) {
            throw new DatasetUnavailable;
        }
    }

    /** @param array<string, mixed> $part */
    public function imagePathFor(array $part): ?string
    {
        $imageFile = $part['image_file'] ?? null;

        if (! is_string($imageFile) || ! $this->validImageFileName($imageFile)) {
            return null;
        }

        try {
            $mediaRoot = realpath($this->configuredPath('media_path'));
        } catch (DatasetUnavailable) {
            return null;
        }

        if (! is_string($mediaRoot) || ! is_dir($mediaRoot)) {
            return null;
        }

        $candidate = realpath($mediaRoot.DIRECTORY_SEPARATOR.$imageFile);

        if (! is_string($candidate) || ! is_file($candidate)) {
            return null;
        }

        $normalizedRoot = rtrim(str_replace('\\', '/', $mediaRoot), '/').'/';
        $normalizedCandidate = str_replace('\\', '/', $candidate);

        if (! str_starts_with($normalizedCandidate, $normalizedRoot)) {
            return null;
        }

        $imageInfo = @getimagesize($candidate);

        if (! is_array($imageInfo) || ! in_array($imageInfo['mime'] ?? null, self::IMAGE_MIME_TYPES, true)) {
            return null;
        }

        return $candidate;
    }

    private function path(): string
    {
        return $this->configuredPath('data_path');
    }

    private function configuredPath(string $key): string
    {
        $configured = config('profile-mfg-poc.'.$key);

        if (! is_string($configured) || trim($configured) === '') {
            throw new DatasetUnavailable;
        }

        $normalized = str_replace('\\', '/', trim($configured));

        if (preg_match('#^[A-Za-z]:/#', $normalized) === 1 || str_starts_with($normalized, '/') || str_starts_with($normalized, '//')) {
            return $normalized;
        }

        return base_path($normalized);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function validate(array $data): void
    {
        if (($data['schema_version'] ?? null) !== 1) {
            throw new DatasetUnavailable;
        }

        $this->requireDate($data, 'snapshot_date');

        foreach (['customers', 'parts', 'orders'] as $collection) {
            if (! isset($data[$collection]) || ! is_array($data[$collection]) || ! array_is_list($data[$collection])) {
                throw new DatasetUnavailable;
            }
        }

        if (isset($data['scans']) && (! is_array($data['scans']) || ! array_is_list($data['scans']))) {
            throw new DatasetUnavailable;
        }

        $customerIds = [];

        foreach ($data['customers'] as $customer) {
            $this->requireRecord($customer);
            $this->requireUniqueId($customer, $customerIds);
            $this->requireString($customer, 'name');
            $this->requireStatus($customer, self::CUSTOMER_STATUSES);
            $this->optionalMap($customer, 'primary_contact');
            $this->optionalMap($customer, 'billing_address');
            $this->optionalMap($customer, 'shipping_address');
            $this->optionalString($customer, 'shipping_instructions');
            $this->optionalMap($customer, 'additional_fields');
        }

        $partIds = [];
        $partCustomers = [];

        foreach ($data['parts'] as $part) {
            $this->requireRecord($part);
            $partId = $this->requireUniqueId($part, $partIds);
            $customerId = $this->requireString($part, 'customer_id');

            if (! isset($customerIds[$customerId])) {
                throw new DatasetUnavailable;
            }

            foreach (['internal_part_number', 'customer_part_number', 'description', 'program', 'profile', 'production_line', 'material_description', 'blueprint_revision', 'notes', 'image_file'] as $field) {
                $this->optionalString($part, $field);
            }

            if (isset($part['image_file']) && ! $this->validImageFileName($part['image_file'])) {
                throw new DatasetUnavailable;
            }

            $this->requireStatus($part, self::PART_STATUSES);
            $this->optionalNonNegativeNumber($part, 'pieces_per_box');
            $this->optionalNonNegativeNumber($part, 'weight_lbs_per_piece');
            $this->optionalMap($part, 'additional_fields');

            if (array_key_exists('inventory', $part) && $part['inventory'] !== null) {
                if (! is_array($part['inventory'])) {
                    throw new DatasetUnavailable;
                }

                $this->optionalNonNegativeNumber($part['inventory'], 'quantity_on_hand');
                $this->optionalNonNegativeNumber($part['inventory'], 'serialized_boxes_on_hand');
                $this->optionalDateTime($part['inventory'], 'last_scan_at');
            }

            $partCustomers[$partId] = $customerId;
        }

        $scanIds = [];

        foreach ($data['scans'] ?? [] as $scan) {
            $this->requireRecord($scan);
            $this->requireUniqueId($scan, $scanIds);
            $partId = $this->requireString($scan, 'part_id');

            if (! isset($partIds[$partId])) {
                throw new DatasetUnavailable;
            }

            $this->requireAllowedValue($scan, 'direction', self::SCAN_DIRECTIONS);
            $this->requireDate($scan, 'manufactured_date');
            $this->requireString($scan, 'serial_number');
            $this->requireDateTime($scan, 'scanned_at');
            $this->requireAllowedValue($scan, 'status', self::SCAN_STATUSES);
            $this->optionalString($scan, 'message');
            $this->optionalMap($scan, 'additional_fields');
        }

        $orderIds = [];

        foreach ($data['orders'] as $order) {
            $this->requireRecord($order);
            $this->requireUniqueId($order, $orderIds);
            $customerId = $this->requireString($order, 'customer_id');
            $partId = $this->requireString($order, 'part_id');

            if (! isset($customerIds[$customerId], $partIds[$partId]) || $partCustomers[$partId] !== $customerId) {
                throw new DatasetUnavailable;
            }

            $original = $this->requireNonNegativeNumber($order, 'original_quantity');
            $remaining = $this->requireNonNegativeNumber($order, 'remaining_quantity');

            if ($remaining > $original) {
                throw new DatasetUnavailable;
            }

            $this->requireDate($order, 'due_date');
            $this->requireStatus($order, self::ORDER_STATUSES);
            $this->optionalString($order, 'notes');
            $this->optionalMap($order, 'additional_fields');
        }
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function enrich(array $data): array
    {
        $snapshot = new DateTimeImmutable($data['snapshot_date']);
        $currentWeekStart = $snapshot->modify('monday this week');
        $scheduleDates = $this->businessDates($currentWeekStart, 10, $snapshot);
        $currentWeekEnd = new DateTimeImmutable($scheduleDates[4]['date']);
        $scheduleEnd = new DateTimeImmutable($scheduleDates[9]['date']);
        $weeksThreeAndFourEnd = $scheduleEnd->modify('+14 days');
        $weeksFiveThroughTenEnd = $weeksThreeAndFourEnd->modify('+42 days');
        $customers = [];
        $parts = [];
        $orders = [];
        $scans = [];

        foreach ($data['customers'] as $customer) {
            $customer['part_ids'] = [];
            $customer['orders'] = [];
            $customers[$customer['id']] = $customer;
        }

        foreach ($data['parts'] as $part) {
            $part['inventory'] = is_array($part['inventory'] ?? null) ? $part['inventory'] : [];
            $part['customer'] = $this->customerContext($customers[$part['customer_id']]);
            $part['orders'] = [];
            $part['scans'] = [];
            $part['has_image'] = $this->imagePathFor($part) !== null;
            $parts[$part['id']] = $part;
            $customers[$part['customer_id']]['part_ids'][] = $part['id'];
        }

        foreach ($data['orders'] as $order) {
            $part = $parts[$order['part_id']];
            $order['ship_date_label'] = $this->dateLabel($order['due_date']);
            $order['completed_quantity'] = $order['original_quantity'] - $order['remaining_quantity'];
            $order['schedule_state'] = $this->scheduleState(
                $order,
                $snapshot,
                $currentWeekEnd,
                $scheduleEnd,
            );
            $order['pack_plan'] = $this->packPlan($order['remaining_quantity'], $part['pieces_per_box'] ?? null);
            $order['customer'] = $this->customerContext($customers[$order['customer_id']]);
            $order['part'] = $this->partContext($part);
            $orders[$order['id']] = $order;

            if (in_array($order['status'], self::OPEN_ORDER_STATUSES, true)) {
                $customers[$order['customer_id']]['orders'][] = $order;
                $parts[$order['part_id']]['orders'][] = $order;
            }
        }

        foreach ($data['scans'] ?? [] as $scan) {
            $part = $parts[$scan['part_id']];
            $scanDate = new DateTimeImmutable($scan['scanned_at']);
            $scan['scanned_at_label'] = $this->dateTimeLabel($scan['scanned_at']);
            $scan['manufactured_date_label'] = $this->dateLabel($scan['manufactured_date']);
            $scan['direction_label'] = $scan['direction'] === 'in' ? 'Scanned in' : 'Scanned out';
            $scan['status_label'] = $scan['status'] === 'accepted' ? 'Accepted' : 'Exception';
            $scan['pieces'] = $scan['status'] === 'accepted' && is_numeric($part['pieces_per_box'] ?? null)
                ? $part['pieces_per_box']
                : null;
            $scan['is_snapshot_date'] = $scanDate->format('Y-m-d') === $data['snapshot_date'];
            $scan['customer'] = $part['customer'];
            $scan['part'] = $this->partContext($part);
            $scans[$scan['id']] = $scan;
            $parts[$scan['part_id']]['scans'][] = $scan;
        }

        foreach ($parts as $partId => $part) {
            $parts[$partId] = $this->enrichPart(
                $part,
                $scheduleDates,
                $snapshot,
                $currentWeekStart,
                $scheduleEnd,
                $weeksThreeAndFourEnd,
                $weeksFiveThroughTenEnd,
            );
        }

        foreach ($customers as $customerId => $customer) {
            $customerParts = array_map(
                fn (string $partId): array => $parts[$partId],
                $customer['part_ids'],
            );
            unset($customer['part_ids']);
            $customer['parts'] = $customerParts;
            $customer['shipping_schedule'] = array_values(array_filter(
                $customerParts,
                fn (array $part): bool => $part['metrics']['open_demand'] > 0,
            ));
            $customer['metrics'] = [
                'active_parts' => count(array_filter(
                    $customerParts,
                    fn (array $part): bool => $part['status'] === 'active',
                )),
                'open_orders' => count($customer['orders']),
                'open_demand' => array_sum(array_column($customer['orders'], 'remaining_quantity')),
                'past_due_demand' => $this->sumOrders($customer['orders'], fn (array $order): bool => $order['due_date'] < $data['snapshot_date']),
                'demand_through_schedule' => $this->sumOrders($customer['orders'], fn (array $order): bool => $order['due_date'] <= $scheduleEnd->format('Y-m-d')),
                'nearest_ship_date' => $this->nearestShipDate($customer['orders']),
            ];
            $customers[$customerId] = $customer;
        }

        $openOrders = array_values(array_filter(
            $orders,
            fn (array $order): bool => in_array($order['status'], self::OPEN_ORDER_STATUSES, true),
        ));
        usort($openOrders, fn (array $left, array $right): int => [$left['due_date'], $left['id']] <=> [$right['due_date'], $right['id']]);
        $todayOrders = array_values(array_filter(
            $openOrders,
            fn (array $order): bool => $order['due_date'] === $data['snapshot_date'],
        ));
        $shippingFocusDate = $data['snapshot_date'];
        $shippingFocusOrders = $todayOrders;

        if ($shippingFocusOrders === []) {
            foreach ($openOrders as $order) {
                if ($order['due_date'] > $data['snapshot_date']) {
                    $shippingFocusDate = $order['due_date'];
                    break;
                }
            }

            $shippingFocusOrders = array_values(array_filter(
                $openOrders,
                fn (array $order): bool => $order['due_date'] === $shippingFocusDate,
            ));
        }

        $sortedOrders = array_values($orders);
        usort($sortedOrders, function (array $left, array $right): int {
            $priority = ['shorted' => 0, 'open' => 0, 'closed' => 1, 'cancelled' => 2];

            return [$priority[$left['status']] ?? 4, $left['due_date'], $left['id']]
                <=> [$priority[$right['status']] ?? 4, $right['due_date'], $right['id']];
        });

        $shippingSchedule = array_values(array_filter(
            $parts,
            fn (array $part): bool => $part['customer']['status'] === 'active'
                && $part['status'] !== 'obsolete'
                && $part['metrics']['open_demand'] > 0,
        ));
        usort($shippingSchedule, fn (array $left, array $right): int => [
            $left['customer']['name'],
            $left['internal_part_number'] ?? $left['id'],
        ] <=> [
            $right['customer']['name'],
            $right['internal_part_number'] ?? $right['id'],
        ]);

        $inventory = array_values($parts);
        usort($inventory, function (array $left, array $right): int {
            $priority = ['short' => 0, 'verify' => 1, 'unknown' => 2, 'ready' => 3, 'no_demand' => 4];

            return [
                $priority[$left['inventory_metrics']['coverage_state']] ?? 5,
                $left['customer']['name'],
                $left['internal_part_number'] ?? $left['id'],
            ] <=> [
                $priority[$right['inventory_metrics']['coverage_state']] ?? 5,
                $right['customer']['name'],
                $right['internal_part_number'] ?? $right['id'],
            ];
        });

        $inventoryExceptions = array_values(array_filter(
            $inventory,
            fn (array $part): bool => $part['metrics']['demand_through_schedule'] > 0
                && $part['inventory_metrics']['coverage_state'] !== 'ready',
        ));

        $scheduledCustomerIds = array_fill_keys(array_column($openOrders, 'customer_id'), true);
        $shippingNotes = array_values(array_filter(
            $customers,
            fn (array $customer): bool => isset($scheduledCustomerIds[$customer['id']]),
        ));
        usort($shippingNotes, fn (array $left, array $right): int => $left['name'] <=> $right['name']);

        $scanActivity = array_values($scans);
        usort($scanActivity, fn (array $left, array $right): int => [$right['scanned_at'], $right['id']] <=> [$left['scanned_at'], $left['id']]);
        $snapshotScans = array_values(array_filter($scanActivity, fn (array $scan): bool => $scan['is_snapshot_date']));
        $acceptedScansIn = array_values(array_filter($snapshotScans, fn (array $scan): bool => $scan['direction'] === 'in' && $scan['status'] === 'accepted'));
        $acceptedScansOut = array_values(array_filter($snapshotScans, fn (array $scan): bool => $scan['direction'] === 'out' && $scan['status'] === 'accepted'));
        $scanExceptions = array_values(array_filter($snapshotScans, fn (array $scan): bool => $scan['status'] === 'rejected'));

        return [
            'schema_version' => 1,
            'snapshot_date' => $data['snapshot_date'],
            'snapshot_label' => $this->dateLabel($data['snapshot_date']),
            'schedule_dates' => $scheduleDates,
            'schedule_end_label' => $this->dateLabel($scheduleEnd->format('Y-m-d')),
            'customers' => array_values($customers),
            'customers_by_id' => $customers,
            'parts' => array_values($parts),
            'parts_by_id' => $parts,
            'orders' => $sortedOrders,
            'orders_by_id' => $orders,
            'inventory' => $inventory,
            'scans' => $scanActivity,
            'scans_by_id' => $scans,
            'scan_summary' => [
                'scanned_in' => count($acceptedScansIn),
                'pieces_received' => $this->sumPresent(array_column($acceptedScansIn, 'pieces')),
                'scanned_out' => count($acceptedScansOut),
                'pieces_shipped' => $this->sumPresent(array_column($acceptedScansOut, 'pieces')),
                'exceptions' => count($scanExceptions),
            ],
            'orders_summary' => [
                'total' => count($orders),
                'open' => count($openOrders),
                'shorted' => count(array_filter($openOrders, fn (array $order): bool => $order['status'] === 'shorted')),
                'past_due' => count(array_filter($openOrders, fn (array $order): bool => $order['due_date'] < $data['snapshot_date'])),
                'due_today' => count(array_filter($openOrders, fn (array $order): bool => $order['due_date'] === $data['snapshot_date'])),
                'open_demand' => array_sum(array_column($openOrders, 'remaining_quantity')),
                'past_due_demand' => $this->sumOrders($openOrders, fn (array $order): bool => $order['due_date'] < $data['snapshot_date']),
                'ship_today_demand' => $this->sumOrders($openOrders, fn (array $order): bool => $order['due_date'] === $data['snapshot_date']),
            ],
            'inventory_summary' => [
                'demand_through_schedule' => $this->sumPresent(array_map(
                    fn (array $part): mixed => $part['metrics']['demand_through_schedule'],
                    $inventory,
                )),
                'system_balance' => $this->sumPresent(array_map(
                    fn (array $part): mixed => $part['inventory_metrics']['system_balance'],
                    $inventory,
                )),
                'serialized_boxes' => $this->sumPresent(array_map(
                    fn (array $part): mixed => $part['inventory_metrics']['serialized_boxes'],
                    $inventory,
                )),
                'serialized_full_box_pieces' => $this->sumPresent(array_map(
                    fn (array $part): mixed => $part['inventory_metrics']['serialized_full_box_pieces'],
                    $inventory,
                )),
                'review_count' => count($inventoryExceptions),
            ],
            'dashboard' => [
                'past_due_demand' => $this->sumOrders($openOrders, fn (array $order): bool => $order['due_date'] < $data['snapshot_date']),
                'ship_today' => $this->sumOrders($openOrders, fn (array $order): bool => $order['due_date'] === $data['snapshot_date']),
                'due_rest_of_week' => $this->sumOrders($openOrders, fn (array $order): bool => $order['due_date'] > $data['snapshot_date'] && $order['due_date'] <= $currentWeekEnd->format('Y-m-d')),
                'due_next_week' => $this->sumOrders($openOrders, fn (array $order): bool => $order['due_date'] > $currentWeekEnd->format('Y-m-d') && $order['due_date'] <= $scheduleEnd->format('Y-m-d')),
                'inventory_review_count' => count($inventoryExceptions),
                'today_orders' => $todayOrders,
                'shipping_focus_date' => $shippingFocusDate,
                'shipping_focus_date_label' => $this->dateLabel($shippingFocusDate),
                'shipping_focus_is_snapshot_date' => $shippingFocusDate === $data['snapshot_date'],
                'shipping_focus_orders' => $shippingFocusOrders,
                'priority_orders' => array_slice($openOrders, 0, 5),
                'priority_inventory' => array_slice($inventoryExceptions, 0, 5),
                'schedule' => $shippingSchedule,
                'inventory_exceptions' => $inventoryExceptions,
                'shipping_notes' => $shippingNotes,
            ],
        ];
    }

    /**
     * @param  array<string, mixed>  $part
     * @param  list<array<string, mixed>>  $scheduleDates
     * @return array<string, mixed>
     */
    private function enrichPart(
        array $part,
        array $scheduleDates,
        DateTimeImmutable $snapshot,
        DateTimeImmutable $scheduleStart,
        DateTimeImmutable $scheduleEnd,
        DateTimeImmutable $weeksThreeAndFourEnd,
        DateTimeImmutable $weeksFiveThroughTenEnd,
    ): array {
        $systemBalance = $part['inventory']['quantity_on_hand'] ?? null;
        $serializedBoxes = $part['inventory']['serialized_boxes_on_hand'] ?? null;
        $piecesPerBox = $part['pieces_per_box'] ?? null;
        $serializedFullBoxPieces = is_numeric($serializedBoxes) && is_numeric($piecesPerBox)
            ? $serializedBoxes * $piecesPerBox
            : null;
        $openDemand = array_sum(array_column($part['orders'], 'remaining_quantity'));
        $demandThroughSchedule = $this->sumOrders(
            $part['orders'],
            fn (array $order): bool => $order['due_date'] <= $scheduleEnd->format('Y-m-d'),
        );
        $demandByDate = [];
        $ordersByDate = [];

        foreach ($scheduleDates as $date) {
            $demandByDate[$date['date']] = 0;
            $ordersByDate[$date['date']] = [];
        }

        $pastDueBeforeWindow = 0;
        $weeksThreeAndFour = 0;
        $weeksFiveThroughTen = 0;
        $laterDemand = 0;

        foreach ($part['orders'] as $order) {
            if (isset($demandByDate[$order['due_date']])) {
                $demandByDate[$order['due_date']] += $order['remaining_quantity'];
                $ordersByDate[$order['due_date']][] = $order;
            } elseif ($order['due_date'] < $scheduleStart->format('Y-m-d')) {
                $pastDueBeforeWindow += $order['remaining_quantity'];
            } elseif ($order['due_date'] <= $weeksThreeAndFourEnd->format('Y-m-d')) {
                $weeksThreeAndFour += $order['remaining_quantity'];
            } elseif ($order['due_date'] <= $weeksFiveThroughTenEnd->format('Y-m-d')) {
                $weeksFiveThroughTen += $order['remaining_quantity'];
            } else {
                $laterDemand += $order['remaining_quantity'];
            }
        }

        $part['metrics'] = [
            'open_orders' => count($part['orders']),
            'open_demand' => $openDemand,
            'past_due_demand' => $this->sumOrders($part['orders'], fn (array $order): bool => $order['due_date'] < $snapshot->format('Y-m-d')),
            'demand_through_schedule' => $demandThroughSchedule,
            'next_ship_date' => $this->nearestShipDate($part['orders']),
        ];
        $part['inventory_metrics'] = [
            'system_balance' => $systemBalance,
            'serialized_boxes' => $serializedBoxes,
            'serialized_full_box_pieces' => $serializedFullBoxPieces,
            'last_scan_label' => is_string($part['inventory']['last_scan_at'] ?? null)
                ? $this->dateTimeLabel($part['inventory']['last_scan_at'])
                : null,
            'balance_difference' => is_numeric($systemBalance) && is_numeric($serializedFullBoxPieces)
                ? $systemBalance - $serializedFullBoxPieces
                : null,
            'coverage_state' => $this->coverageState($demandThroughSchedule, $systemBalance, $serializedFullBoxPieces),
        ];
        $part['schedule'] = [
            'past_due_before_window' => $pastDueBeforeWindow,
            'demand_by_date' => $demandByDate,
            'orders_by_date' => $ordersByDate,
            'weeks_three_and_four' => $weeksThreeAndFour,
            'weeks_five_through_ten' => $weeksFiveThroughTen,
            'later_demand' => $laterDemand,
        ];

        return $part;
    }

    private function validImageFileName(mixed $value): bool
    {
        return is_string($value)
            && basename($value) === $value
            && preg_match('/^[A-Za-z0-9][A-Za-z0-9._-]*\.(?:gif|jpe?g|png|webp)$/i', $value) === 1;
    }

    /**
     * @return list<array{date: string, day_label: string, date_label: string, is_snapshot: bool, is_past: bool}>
     */
    private function businessDates(DateTimeImmutable $start, int $count, DateTimeImmutable $snapshot): array
    {
        $dates = [];
        $cursor = $start;

        while (count($dates) < $count) {
            if ((int) $cursor->format('N') <= 5) {
                $date = $cursor->format('Y-m-d');
                $dates[] = [
                    'date' => $date,
                    'day_label' => $cursor->format('D'),
                    'date_label' => $cursor->format('M j'),
                    'is_snapshot' => $date === $snapshot->format('Y-m-d'),
                    'is_past' => $date < $snapshot->format('Y-m-d'),
                ];
            }

            $cursor = $cursor->modify('+1 day');
        }

        return $dates;
    }

    /** @param array<string, mixed> $order */
    private function scheduleState(
        array $order,
        DateTimeImmutable $snapshot,
        DateTimeImmutable $currentWeekEnd,
        DateTimeImmutable $scheduleEnd,
    ): string {
        if ($order['status'] === 'closed') {
            return 'complete';
        }

        if ($order['status'] === 'cancelled') {
            return 'cancelled';
        }

        if ($order['due_date'] < $snapshot->format('Y-m-d')) {
            return 'past_due';
        }

        if ($order['due_date'] === $snapshot->format('Y-m-d')) {
            return 'due_today';
        }

        if ($order['due_date'] <= $currentWeekEnd->format('Y-m-d')) {
            return 'due_this_week';
        }

        if ($order['due_date'] <= $scheduleEnd->format('Y-m-d')) {
            return 'next_week';
        }

        return 'upcoming';
    }

    private function coverageState(int|float $demand, mixed $systemBalance, mixed $serializedFullBoxPieces): string
    {
        if ($demand <= 0) {
            return 'no_demand';
        }

        $systemCovers = is_numeric($systemBalance) ? $systemBalance >= $demand : null;
        $serializedCovers = is_numeric($serializedFullBoxPieces) ? $serializedFullBoxPieces >= $demand : null;

        if ($systemCovers === null && $serializedCovers === null) {
            return 'unknown';
        }

        if ($systemCovers === true && $serializedCovers === true) {
            return 'ready';
        }

        if ($systemCovers === false && $serializedCovers === false) {
            return 'short';
        }

        return 'verify';
    }

    /** @return array{full_boxes: int|null, loose_pieces: int|float|null, boxes_required: int|null} */
    private function packPlan(int|float $remainingQuantity, mixed $piecesPerBox): array
    {
        if (! is_numeric($piecesPerBox) || $piecesPerBox <= 0) {
            return ['full_boxes' => null, 'loose_pieces' => null, 'boxes_required' => null];
        }

        $fullBoxes = (int) floor($remainingQuantity / $piecesPerBox);

        return [
            'full_boxes' => $fullBoxes,
            'loose_pieces' => $remainingQuantity - ($fullBoxes * $piecesPerBox),
            'boxes_required' => (int) ceil($remainingQuantity / $piecesPerBox),
        ];
    }

    /** @param list<array<string, mixed>> $orders */
    private function sumOrders(array $orders, callable $matches): int|float
    {
        return array_sum(array_map(
            fn (array $order): int|float => $matches($order) ? $order['remaining_quantity'] : 0,
            $orders,
        ));
    }

    /** @param list<mixed> $values */
    private function sumPresent(array $values): int|float
    {
        return array_sum(array_filter($values, fn (mixed $value): bool => is_numeric($value)));
    }

    /** @param array<string, mixed> $record */
    private function requireRecord(mixed $record): void
    {
        if (! is_array($record) || array_is_list($record)) {
            throw new DatasetUnavailable;
        }
    }

    /**
     * @param  array<string, mixed>  $record
     * @param  array<string, true>  $ids
     */
    private function requireUniqueId(array $record, array &$ids): string
    {
        $id = $this->requireString($record, 'id');

        if (isset($ids[$id])) {
            throw new DatasetUnavailable;
        }

        $ids[$id] = true;

        return $id;
    }

    /** @param array<string, mixed> $record */
    private function requireString(array $record, string $field): string
    {
        $value = $record[$field] ?? null;

        if (! is_string($value) || trim($value) === '') {
            throw new DatasetUnavailable;
        }

        return $value;
    }

    /** @param array<string, mixed> $record */
    private function optionalString(array $record, string $field): void
    {
        if (array_key_exists($field, $record) && $record[$field] !== null && ! is_string($record[$field])) {
            throw new DatasetUnavailable;
        }
    }

    /**
     * @param  array<string, mixed>  $record
     * @param  list<string>  $allowed
     */
    private function requireStatus(array $record, array $allowed): void
    {
        $status = $this->requireString($record, 'status');

        if (! in_array($status, $allowed, true)) {
            throw new DatasetUnavailable;
        }
    }

    /**
     * @param  array<string, mixed>  $record
     * @param  list<string>  $allowed
     */
    private function requireAllowedValue(array $record, string $field, array $allowed): void
    {
        $value = $this->requireString($record, $field);

        if (! in_array($value, $allowed, true)) {
            throw new DatasetUnavailable;
        }
    }

    /** @param array<string, mixed> $record */
    private function requireDate(array $record, string $field): void
    {
        $value = $this->requireString($record, $field);
        $date = DateTimeImmutable::createFromFormat('!Y-m-d', $value);

        if (! $date instanceof DateTimeImmutable || $date->format('Y-m-d') !== $value) {
            throw new DatasetUnavailable;
        }
    }

    /** @param array<string, mixed> $record */
    private function optionalDateTime(array $record, string $field): void
    {
        if (! array_key_exists($field, $record) || $record[$field] === null) {
            return;
        }

        if (! is_string($record[$field])) {
            throw new DatasetUnavailable;
        }

        try {
            new DateTimeImmutable($record[$field]);
        } catch (Throwable) {
            throw new DatasetUnavailable;
        }
    }

    /** @param array<string, mixed> $record */
    private function requireDateTime(array $record, string $field): void
    {
        $this->requireString($record, $field);
        $this->optionalDateTime($record, $field);
    }

    /** @param array<string, mixed> $record */
    private function requireNonNegativeNumber(array $record, string $field): int|float
    {
        $value = $record[$field] ?? null;

        if ((! is_int($value) && ! is_float($value)) || $value < 0) {
            throw new DatasetUnavailable;
        }

        return $value;
    }

    /** @param array<string, mixed> $record */
    private function optionalNonNegativeNumber(array $record, string $field): void
    {
        if (! array_key_exists($field, $record) || $record[$field] === null) {
            return;
        }

        $this->requireNonNegativeNumber($record, $field);
    }

    /** @param array<string, mixed> $record */
    private function optionalMap(array $record, string $field): void
    {
        if (! array_key_exists($field, $record) || $record[$field] === null) {
            return;
        }

        if (! is_array($record[$field]) || ($record[$field] !== [] && array_is_list($record[$field]))) {
            throw new DatasetUnavailable;
        }

        foreach ($record[$field] as $key => $value) {
            if (! is_string($key) || trim($key) === '' || (! is_scalar($value) && $value !== null)) {
                throw new DatasetUnavailable;
            }
        }
    }

    /** @param array<string, mixed> $customer */
    private function customerContext(array $customer): array
    {
        return [
            'id' => $customer['id'],
            'name' => $customer['name'],
            'status' => $customer['status'],
        ];
    }

    /** @param array<string, mixed> $part */
    private function partContext(array $part): array
    {
        return [
            'id' => $part['id'],
            'internal_part_number' => $part['internal_part_number'] ?? null,
            'customer_part_number' => $part['customer_part_number'] ?? null,
            'description' => $part['description'] ?? null,
        ];
    }

    /** @param list<array<string, mixed>> $orders */
    private function nearestShipDate(array $orders): ?string
    {
        $dates = array_column($orders, 'due_date');
        sort($dates);

        return isset($dates[0]) ? $this->dateLabel($dates[0]) : null;
    }

    private function dateLabel(string $date): string
    {
        return (new DateTimeImmutable($date))->format('M j, Y');
    }

    private function dateTimeLabel(string $date): string
    {
        return (new DateTimeImmutable($date))->format('M j, Y g:i A');
    }
}
