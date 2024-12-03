<?php

namespace App\Traits;

trait FormatsDates
{
    /**
     * Format a date to the desired format.
     *
     * @param \DateTimeInterface|string|null $date
     * @param  string  $format
     * @return string|null
     */
    protected function formatDate(\DateTimeInterface|string|null $date, string $format = 'Y-m-d H:i:s'): ?string
    {
        if (!$date) {
            return null;
        }

        if ($date instanceof \DateTimeInterface) {
            return $date->format($format);
        }

        try {
            return (new \DateTime($date))->format($format);
        } catch (\Exception $e) {
            return null;
        }
    }
}
