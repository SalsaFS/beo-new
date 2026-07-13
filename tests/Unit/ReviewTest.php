<?php

namespace Tests\Unit;

use App\Models\Review;
use PHPUnit\Framework\TestCase;

class ReviewTest extends TestCase
{
    /**
     * Test that the Review model has the correct table name.
     */
    public function test_review_model_has_correct_table_name(): void
    {
        $review = new Review();
        $this->assertEquals('reviews', $review->getTable());
    }

    /**
     * Test that the Review model has the correct fillable attributes.
     */
    public function test_review_model_has_correct_fillable_attributes(): void
    {
        $review = new Review();
        $expectedFillable = ['platform_id', 'guest', 'date_issued', 'review'];
        $this->assertEquals($expectedFillable, $review->getFillable());
    }

    /**
     * Test that the Review model uses timestamps.
     */
    public function test_review_model_uses_timestamps(): void
    {
        $review = new Review();
        $this->assertTrue($review->usesTimestamps());
    }

    /**
     * Test that the Review model has a platform method that returns a relationship.
     */
    public function test_review_has_platform_relationship_method(): void
    {
        $review = new Review();
        $this->assertTrue(method_exists($review, 'platform'));
    }
}
