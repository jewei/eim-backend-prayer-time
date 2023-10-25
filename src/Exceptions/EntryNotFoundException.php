<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Contracts\NotFoundExceptionInterface;
use Exception;

final class EntryNotFoundException extends Exception implements NotFoundExceptionInterface
{
}
