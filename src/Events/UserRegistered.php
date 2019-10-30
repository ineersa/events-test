<?php
declare(strict_types=1);

namespace App\Events;

use App\Interfaces\EventInterface;

final class UserRegistered implements EventInterface
{
    /**
     * @var int
     */
    private $time;
    /**
     * @var int
     */
    private $userId;
    /**
     * @var string
     */
    private $source;

    public function __construct(int $time, int $userId, string $source)
    {
        $this->setTime($time);
        $this->setUserId($userId);
        $this->setSource($source);
    }

    /**
     * @return int
     */
    public function getTime(): int
    {
        return $this->time;
    }

    /**
     * @param int $time
     */
    public function setTime(int $time): void
    {
        $this->time = $time;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource(string $source): void
    {
        $this->source = $source;
    }
}