<?php

namespace Tests\Unit\Traits;

use App\Traits\FormatsDates;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class FormatsDatesTest extends TestCase
{
    use FormatsDates;

    /**
     * @return void
     */
    public function test_format_date_with_datetime_object(): void
    {
        $date = new \DateTime('2024-12-01 15:30:00');
        $formattedDate = $this->formatDate($date, 'Y-m-d');

        $this->assertEquals('2024-12-01', $formattedDate);
    }

    /**
     * @return void
     */
    public function test_format_date_with_string(): void
    {
        $date = '2024-12-01 15:30:00';
        $formattedDate = $this->formatDate($date, 'Y-m-d');

        $this->assertEquals('2024-12-01', $formattedDate);
    }

    /**
     * @return void
     */
    public function test_format_date_with_invalid_string(): void
    {
        $date = 'invalid date';
        $formattedDate = $this->formatDate($date, 'Y-m-d');

        $this->assertNull($formattedDate);
    }

    /**
     * @return void
     */
    public function test_format_date_with_null(): void
    {
        $formattedDate = $this->formatDate(null, 'Y-m-d');

        $this->assertNull($formattedDate);
    }

    /**
     * @return void
     */
    public function test_format_date_with_default_format(): void
    {
        $date = '2024-12-01 15:30:00';
        $formattedDate = $this->formatDate($date);

        $this->assertEquals('2024-12-01 15:30:00', $formattedDate);
    }
}
