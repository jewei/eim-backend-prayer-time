<?php

declare(strict_types=1);

namespace App\Traits;

use App\Contracts\CommandInterface;
use Exception;
use SplFileInfo;
use Throwable;

trait HasInterationHandlers
{
    public function handleHttpRequest(string $method, string $uri): void
    {
        try {
            $this->router()->handle($method, $uri)->send();
        } catch (Throwable $throwable) {
            $this->log('error', $throwable->getMessage(), [
                'file' => $throwable->getFile(),
                'line' => $throwable->getLine(),
            ]);
            $this->router()->handleException();
        }
    }

    /**
     * @param  array<int, string>  $values
     */
    public function handleConsoleCommand(array $values): void
    {
        try {
            if ($values === []) {
                throw new Exception('Missing command.');
            }

            $items = glob(base_path('src/Commands').'/*.php', GLOB_NOSORT);
            if ($items === false) {
                throw new Exception('Commands not found.');
            }

            foreach ($items as $item) {
                $file = new SplFileInfo($item);
                if ($values[0] === $name = strtolower(str_replace('.php', '', $file->getFilename()))) {
                    $command = 'App\Commands\\'.ucfirst($name);
                    if (is_subclass_of($command, CommandInterface::class)) {
                        (new $command($this))->handle($values);
                        exit(0);
                    }
                }
            }

            throw new Exception('Command not found: '.$values[0]);
        } catch (Throwable $throwable) {
            $this->log('error', $throwable->getMessage(), [
                'file' => $throwable->getFile(),
                'line' => $throwable->getLine(),
            ]);
            echo $throwable->getMessage();
            exit(0);
        }
    }
}
