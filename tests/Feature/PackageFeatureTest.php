<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\PackageBreakdown;
use App\Models\FunctionModel;
use Tests\TestCase;

class PackageFeatureTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Run only the specific migrations needed for these tests
        $this->artisan('migrate:fresh', [
            '--path' => [
                'database/migrations/2026_06_26_084040_create_packages_table.php',
                'database/migrations/2026_06_26_083854_create_functions_table.php',
                'database/migrations/2026_06_26_090433_create_package_breakdowns_table.php',
            ],
            '--realpath' => true,
            '--no-interaction' => true,
        ]);
    }

    protected function tearDown(): void
    {
        $this->artisan('migrate:rollback', [
            '--path' => [
                'database/migrations/2026_06_26_084040_create_packages_table.php',
                'database/migrations/2026_06_26_083854_create_functions_table.php',
                'database/migrations/2026_06_26_090433_create_package_breakdowns_table.php',
            ],
            '--realpath' => true,
            '--no-interaction' => true,
        ]);

        parent::tearDown();
    }

    /**
     * Test that a package can be created with fillable attributes.
     */
    public function test_package_can_be_created(): void
    {
        $package = Package::create([
            'name' => 'Silver Package',
            'type' => 'meeting',
            'description' => 'A basic meeting package',
        ]);

        $this->assertDatabaseHas('packages', [
            'id' => $package->id,
            'name' => 'Silver Package',
            'type' => 'meeting',
            'description' => 'A basic meeting package',
        ]);
    }

    /**
     * Test that a package can be updated.
     */
    public function test_package_can_be_updated(): void
    {
        $package = Package::create([
            'name' => 'Silver Package',
            'type' => 'meeting',
        ]);

        $package->update([
            'name' => 'Gold Package',
            'type' => 'wedding',
        ]);

        $this->assertDatabaseHas('packages', [
            'id' => $package->id,
            'name' => 'Gold Package',
            'type' => 'wedding',
        ]);
    }

    /**
     * Test that a package can be deleted.
     */
    public function test_package_can_be_deleted(): void
    {
        $package = Package::create([
            'name' => 'Silver Package',
            'type' => 'meeting',
        ]);

        $packageId = $package->id;
        $package->delete();

        $this->assertDatabaseMissing('packages', [
            'id' => $packageId,
        ]);
    }

    /**
     * Test that a package has many package breakdowns relationship.
     */
    public function test_package_has_many_package_breakdowns(): void
    {
        $package = Package::create([
            'name' => 'Silver Package',
            'type' => 'meeting',
        ]);

        $function = FunctionModel::create([
            'name' => 'Meeting Function',
            'type' => 'meeting',
        ]);

        $breakdown1 = PackageBreakdown::create([
            'package_id' => $package->id,
            'function_id' => $function->id,
        ]);

        $breakdown2 = PackageBreakdown::create([
            'package_id' => $package->id,
            'function_id' => $function->id,
        ]);

        $this->assertCount(2, $package->packageBreakdowns);
        $this->assertTrue($package->packageBreakdowns->contains($breakdown1));
        $this->assertTrue($package->packageBreakdowns->contains($breakdown2));
    }

    /**
     * Test that creating a package with null type is allowed (type is nullable).
     */
    public function test_package_type_is_nullable(): void
    {
        $package = Package::create([
            'name' => 'Custom Package',
            'type' => null,
        ]);

        $this->assertDatabaseHas('packages', [
            'id' => $package->id,
            'name' => 'Custom Package',
            'type' => null,
        ]);
    }

    /**
     * Test that creating a package without description is allowed (description is nullable).
     */
    public function test_package_description_is_nullable(): void
    {
        $package = Package::create([
            'name' => 'Minimal Package',
            'type' => 'meeting',
        ]);

        $this->assertDatabaseHas('packages', [
            'id' => $package->id,
            'name' => 'Minimal Package',
            'description' => null,
        ]);
    }

    /**
     * Test that name is required to create a package.
     */
    public function test_package_name_is_required(): void
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Package::create([
            'type' => 'meeting',
        ]);
    }

    /**
     * Test that a package breakdown belongs to a package.
     */
    public function test_package_breakdown_belongs_to_package(): void
    {
        $package = Package::create([
            'name' => 'Silver Package',
            'type' => 'meeting',
        ]);

        $function = FunctionModel::create([
            'name' => 'Meeting Function',
            'type' => 'meeting',
        ]);

        $breakdown = PackageBreakdown::create([
            'package_id' => $package->id,
            'function_id' => $function->id,
        ]);

        $this->assertInstanceOf(Package::class, $breakdown->package);
        $this->assertEquals($package->id, $breakdown->package->id);
    }

    /**
     * Test that a package breakdown belongs to a function.
     */
    public function test_package_breakdown_belongs_to_function(): void
    {
        $package = Package::create([
            'name' => 'Silver Package',
            'type' => 'meeting',
        ]);

        $function = FunctionModel::create([
            'name' => 'Meeting Function',
            'type' => 'meeting',
        ]);

        $breakdown = PackageBreakdown::create([
            'package_id' => $package->id,
            'function_id' => $function->id,
        ]);

        $this->assertInstanceOf(FunctionModel::class, $breakdown->function);
        $this->assertEquals($function->id, $breakdown->function->id);
    }
}