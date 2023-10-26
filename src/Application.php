<?php

declare(strict_types=1);

namespace App;

use App\Traits\HasInterationHandlers;
use App\Traits\HasMacros;
use App\Traits\HasServiceProviders;

final class Application extends Container
{
    use HasInterationHandlers;
    use HasMacros;
    use HasServiceProviders;
}
