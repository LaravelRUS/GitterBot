<?php
namespace Interfaces\Gitter;

use Domains\User;
use Domains\Message;
use Interfaces\Gitter\Ai\UserChannel;

/**
 * Class Ai
 */
class Ai
{
    /**
     * @var array|UserChannel[]
     */
    protected $channels = [];

    /**
     * @param Message $message
     */
    public function handle(Message $message)
    {
        $this
            ->getChannel($message->user)
            ->handle($message);
    }

    /**
     * @param User $user
     * @return UserChannel
     */
    protected function getChannel(User $user)
    {
        $key = $user->gitter_id;
        if (!array_key_exists($key, $this->channels)) {
            $this->channels[$key] = new UserChannel($user);
        }
        return $this->channels[$key];
    }
}