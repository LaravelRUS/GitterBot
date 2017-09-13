<?php
/**
 * This file is part of GitterBot package.
 *
 * @author Serafim <nesk@xakep.ru>
 * @date 11.10.2015 6:07
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Domains\Bot\Achievements;

use Domains\Karma;
use Interfaces\Gitter\Achieve\AbstractAchieve;

/**
 * Class Thanks20Achieve
 */
class Thanks20Achieve extends AbstractAchieve
{
    /**
     * @var string
     */
    public $title = 'Благодарный';

    /**
     * @var string
     */
    public $description = 'Высказать 20 благодарностей.';

    /**
     * @var string
     */
    public $image = '//karma.laravel.su/img/achievements/thanks-20.gif';

    /**
     * @throws \LogicException
     */
    public function handle()
    {
        Karma::created(function (Karma $karma) {
            $count = $karma->user->thanks->count();

            if ($count === 20) {
                $this->create($karma->user, $karma->created_at);
            }
        });
    }
}
