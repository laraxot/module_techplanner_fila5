<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for TechPlanner module tests.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}
