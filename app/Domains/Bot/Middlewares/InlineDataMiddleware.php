<?php
namespace Domains\Bot\Middlewares;

use Domains\Message;
use Domains\Middleware\MiddlewareInterface;

/**
 * Class InlineDataMiddleware
 */
class InlineDataMiddleware implements MiddlewareInterface
{
    /**
     * @param Message $message
     * @return mixed
     */
    public function handle(Message $message)
    {
        $isImage = preg_match(
            '/[^`]http(?:s)?:\/\/.*?\.(?:jpg|png|jpeg|svg|bmp)/iu'
        , ' ' . $message->text);

        $isVideo = preg_match(
            '/[^`]http(?:s)?:\/\/(?:www\.)?(?:youtube\.com|youtu\.be).*?/iu'
        , ' ' . $message->text);

        if (($isImage || $isVideo) && ! $message->user->isBot()) {
            $answer = trans('gitter.inline', [
                'user' => $message->user->login
            ]);
            $message->italic($answer);
        }

        return $message;
    }
}
