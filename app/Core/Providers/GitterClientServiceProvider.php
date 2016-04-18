<?php
/**
 * This file is part of GitterBot package.
 *
 * @author Serafim <nesk@xakep.ru>
 * @date 09.04.2016 3:09
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Providers;

use Core\Io\Bus;
use Gitter\Client;
use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use Interfaces\Gitter\Io;

/**
 * Class GitterClientServiceProvider
 * @package Core\Providers
 */
class GitterClientServiceProvider extends ServiceProvider
{
    /**
     * @throws \Exception
     */
    public function register()
    {
        /** @var Repository $config */
        $config = $this->app->make(Repository::class);


        $this->app->singleton(Client::class, function (Container $app) use ($config) {
            return new Client($config->get('gitter.token'));
        });

        $this->app->singleton('bot', function (Container $app) {
            /** @var Client $client */
            $client = $app->make(Client::class);
            return $client->http->getCurrentUser()->wait();
        });
    }
}
