<?php
declare(strict_types=1);

namespace App\Events;

use App\Interfaces\EventInterface;

final class UserPayed implements EventInterface
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
     * @var int
     */
    private $amount;

    public function __construct(int $time, int $userId, int $amount)
    {
        $this->setTime($time);
        $this->setUserId($userId);
        $this->setAmount($amount);
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
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }
}