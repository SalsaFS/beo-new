<?php

namespace Tests\Feature;

use App\Models\Platform;
use App\Models\Review;
use Tests\TestCase;

class ReviewFeatureTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh', [
            '--path' => [
                'database/migrations/2026_06_26_083819_create_platforms_table.php',
                'database/migrations/2026_06_26_084613_create_reviews_table.php',
            ],
            '--realpath' => true,
            '--no-interaction' => true,
        ]);
    }

    protected function tearDown(): void
    {
        $this->artisan('migrate:rollback', [
            '--path' => [
                'database/migrations/2026_06_26_083819_create_platforms_table.php',
                'database/migrations/2026_06_26_084613_create_reviews_table.php',
            ],
            '--realpath' => true,
            '--no-interaction' => true,
        ]);

        parent::tearDown();
    }

    /**
     * Test that a review can be created with fillable attributes.
     */
    public function test_review_can_be_created(): void
    {
        $platform = Platform::create(['name' => 'Google']);

        $review = Review::create([
            'platform_id' => $platform->id,
            'guest' => 'John Doe',
            'date_issued' => '2026-07-11',
            'review' => 'Great experience!',
        ]);

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'platform_id' => $platform->id,
            'guest' => 'John Doe',
            'date_issued' => '2026-07-11',
            'review' => 'Great experience!',
        ]);
    }

    /**
     * Test that a review can be updated.
     */
    public function test_review_can_be_updated(): void
    {
        $platform = Platform::create(['name' => 'Google']);

        $review = Review::create([
            'platform_id' => $platform->id,
            'guest' => 'John Doe',
            'date_issued' => '2026-07-11',
            'review' => 'Great experience!',
        ]);

        $review->update([
            'guest' => 'Jane Doe',
            'review' => 'Updated review',
        ]);

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'guest' => 'Jane Doe',
            'review' => 'Updated review',
        ]);
    }

    /**
     * Test that a review can be deleted.
     */
    public function test_review_can_be_deleted(): void
    {
        $platform = Platform::create(['name' => 'Google']);

        $review = Review::create([
            'platform_id' => $platform->id,
            'guest' => 'John Doe',
            'date_issued' => '2026-07-11',
            'review' => 'Great experience!',
        ]);

        $reviewId = $review->id;
        $review->delete();

        $this->assertDatabaseMissing('reviews', [
            'id' => $reviewId,
        ]);
    }

    /**
     * Test that a review belongs to a platform.
     */
    public function test_review_belongs_to_platform(): void
    {
        $platform = Platform::create(['name' => 'Google']);

        $review = Review::create([
            'platform_id' => $platform->id,
            'guest' => 'John Doe',
            'date_issued' => '2026-07-11',
            'review' => 'Great experience!',
        ]);

        $this->assertInstanceOf(Platform::class, $review->platform);
        $this->assertEquals($platform->id, $review->platform->id);
    }

    /**
     * Test that guest is required to create a review.
     */
    public function test_review_guest_is_required(): void
    {
        $platform = Platform::create(['name' => 'Google']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Review::create([
            'platform_id' => $platform->id,
            'date_issued' => '2026-07-11',
            'review' => 'Great experience!',
        ]);
    }

    /**
     * Test that date_issued and review are nullable.
     */
    public function test_review_date_and_review_are_nullable(): void
    {
        $platform = Platform::create(['name' => 'Google']);

        $review = Review::create([
            'platform_id' => $platform->id,
            'guest' => 'John Doe',
        ]);

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'guest' => 'John Doe',
            'date_issued' => null,
            'review' => null,
        ]);
    }

    /**
     * Test that deleting a platform is restricted when reviews reference it.
     */
    public function test_platform_delete_is_restricted_when_reviews_exist(): void
    {
        $platform = Platform::create(['name' => 'Google']);

        Review::create([
            'platform_id' => $platform->id,
            'guest' => 'John Doe',
            'date_issued' => '2026-07-11',
            'review' => 'Great experience!',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        $platform->delete();
    }
}
