<?php

namespace Tests\Setup;

trait AttributeFactory {
    private function generateTimeSlotAttributes($startDate, $endDate, $locationId, $eventId = null, $amount = 1)
    {
        $timeSlots = [];

        for ($i = 0; $i < $amount; $i++) {
            $startSlot = $this->faker->dateTimeBetween($startDate, $endDate);
            $endSlot = $this->faker->dateTimeBetween($startSlot, $startSlot->format('Y-m-d 23:59:59'));
    
            $timeSlot = [
                'start' => $startSlot->format('c'),
                'end' => $endSlot->format('c'),
                'location_id' => $locationId,
            ];

            if (!is_null($eventId)) {
                $timeSlot['event_id'] = $eventId;
            }

            if ($amount == 1) {
                return $timeSlot;
            }

            array_push($timeSlots, $timeSlot);
        }

        return $timeSlots;
    }

    private function generateEventAttributes($userId)
    {
        $start = $this->faker->dateTimeBetween('-2 days', '+20 days');
        $end = $this->faker->dateTimeBetween($start, $start->format('Y-m-d') . ' +4 days');

        return [
            'user_id' => $userId,
            'title' => $this->faker->name,
            'description' => $this->faker->text(140),
            'start' => $start->format('Y-m-d'),
            'end' => $end->format('Y-m-d'),
        ];
    }
}