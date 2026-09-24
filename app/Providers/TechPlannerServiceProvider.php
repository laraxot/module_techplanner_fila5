<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class TechPlannerServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'TechPlanner';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;
}
