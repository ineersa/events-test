<?php
declare(strict_types=1);

namespace App\Events;

use App\Interfaces\EventInterface;

final class UserBanned implements EventInterface
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
    private $reason;

    public function __construct(int $time, int $userId, string $reason)
    {
        $this->setTime($time);
        $this->setUserId($userId);
        $this->setReason($reason);
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
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     */
    public function setReason(string $reason): void
    {
        $this->reason = $reason;
    }
}