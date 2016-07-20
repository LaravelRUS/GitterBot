<?php
/**
 * This file is part of GitterBot package.
 *
 * @author butschster <butschster@gmail.com>
 * @date 20.07.2016 17:08
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Domains;

use Illuminate\Support\Manager;
use Interfaces\Gitter\Client;

/**
 * Class BotManager
 * @package Domains
 */
class BotManager extends Manager
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return 'gitter';
    }

    /**
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function createGitterDriver()
    {
        return new Client(\Config::get('gitter.token'));
    }
}