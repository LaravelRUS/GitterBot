<?php

/**
 * This file is part of GitterBot package.
 *
 * @author Serafim <nesk@xakep.ru>
 * @date 24.09.2015 15:27
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Interfaces\Console\Commands;


use Carbon\Carbon;
use Domains\Room\Room;
use Gitter\Client;
use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Domains\Bot\Middlewares\Repository as Middlewares;
use Interfaces\Gitter\Factories\Room as RoomFactory;
use Interfaces\Gitter\Factories\Message as MessageFactory;


/**
 * Class StartGitterBot
 */
class StartGitterBot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gitter:listen {room}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start gitter bot thread for target room.';

    /**
     * @var string
     */
    protected $pid;


    /**
     * Execute the console command.
     *
     * @param Repository $config
     * @param Container $container
     * @param Client $client
     * @return mixed
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \LogicException
     * @throws \Exception
     */
    public function handle(Repository $config, Container $container, Client $client)
    {
        $this->makePidFile();

        $room = $this->getRoom($config, $client);


        $middlewares = new Middlewares($container, $room);
        foreach ($config->get('gitter.middlewares') as $middleware) {
            $middlewares->register($middleware);
        }

        $client->stream->onMessage($room->gitterId, function ($data) use ($middlewares, $room) {
            $message = MessageFactory::create($data, $room);

            $middlewares->handle($message);
        });


        $this->info(sprintf('KarmaBot %s started at %s', '0.2b', Carbon::now()));
        $client->stream->listen();
        $this->removePidFile();
    }

    /**
     * @param Repository $config
     * @param Client $client
     * @return Room
     * @throws \Exception
     */
    private function getRoom(Repository $config, Client $client) : Room
    {
        $rooms = $config->get('gitter.rooms');
        if (!array_key_exists($this->argument('room'), $rooms)) {
            throw new \InvalidArgumentException('Can not resolve room ' . $this->argument('room'));
        }

        return RoomFactory::createFromId($client, $rooms[$this->argument('room')]);
    }

    /**
     * Create pid file
     */
    protected function makePidFile()
    {
        $this->pid = storage_path('pids/' . date('Y_m_d_tis_') . microtime(1) . '.pid');
        file_put_contents($this->pid, getmypid());
    }

    /**
     * Delete pid file
     */
    protected function removePidFile()
    {
        if (is_file($this->pid)) {
            unlink($this->pid);
        }
    }
}