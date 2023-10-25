<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Contracts\ContainerExceptionInterface;
use Exception;

final class ContainerException extends Exception implements ContainerExceptionInterface
{
}
