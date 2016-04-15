<?php
namespace Domains\Bot\Middlewares;

use Domains\Message\Message;
use Domains\Bot\Middlewares\Karma\Validator;

/**
 * Проверяет "спасибо" и выводит инкремент.
 *
 * Class KarmaCounterMiddleware
 */
class KarmaCounterMiddleware implements Middleware
{
    /**
     * @var Validator
     */
    protected $validator;

    /**
     * KarmaCounterMiddleware constructor.
     */
    public function __construct()
    {
        $this->validator = new Validator();
    }

    /**
     * @param Message $message
     * @return mixed
     */
    public function handle(Message $message)
    {
        $collection = $this->validator->validate($message);
        $hasAnswers = false;

        foreach ($collection as $state) {
            $user = $state->getUser();

            if ($state->isIncrement()) {
                $message->user->addKarmaTo($user, $message);

                if ($user->id === \Auth::user()->id) {
                    $message->answer(\Lang::get('karma.bot', [
                        'user' => $message->user->login
                    ]));
                }
            }

            if (!$state->isNothing()) {
                $hasAnswers = true;
                $message->italic($state->getTranslation($user->karma_text));
            }
        }

        if (!$hasAnswers) {
            return $message;
        }
    }
}
