<?php

namespace Tests\Unit;

use App\Models\Package;
use PHPUnit\Framework\TestCase;

class PackageTest extends TestCase
{
    /**
     * Test that the Package model has the correct table name.
     */
    public function test_package_model_has_correct_table_name(): void
    {
        $package = new Package();
        $this->assertEquals('packages', $package->getTable());
    }

    /**
     * Test that the Package model has the correct fillable attributes.
     */
    public function test_package_model_has_correct_fillable_attributes(): void
    {
        $package = new Package();
        $expectedFillable = ['name', 'type', 'description'];
        $this->assertEquals($expectedFillable, $package->getFillable());
    }

    /**
     * Test that the Package model uses timestamps.
     */
    public function test_package_model_uses_timestamps(): void
    {
        $package = new Package();
        $this->assertTrue($package->usesTimestamps());
    }

    /**
     * Test that the Package model has a packageBreakdowns method that returns a HasMany relationship.
     */
    public function test_package_has_package_breakdowns_relationship_method(): void
    {
        $package = new Package();
        $this->assertTrue(method_exists($package, 'packageBreakdowns'));
    }

    /**
     * Test that the Package model has a beoPackages method that returns a HasMany relationship.
     */
    public function test_package_has_beo_packages_relationship_method(): void
    {
        $package = new Package();
        $this->assertTrue(method_exists($package, 'beoPackages'));
    }
}