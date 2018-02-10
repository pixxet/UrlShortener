<?php

/*
 * This file is part of the Pixxet\UrlShortener library.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pixxet\UrlShortener\Command;

use Pixxet\UrlShortener\Model\Link;
use Pixxet\UrlShortener\Provider\Bitly\BitlyProvider;
use Pixxet\UrlShortener\Provider\Bitly\OAuthClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Shortens the long given URL using the Bitly API.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class BitlyShortenCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('bitly:shorten')
            ->setDescription('Shortens the long given URL using the Bitly API')

            ->addArgument('username', InputArgument::REQUIRED, 'A valid Bitly username')
            ->addArgument('password', InputArgument::REQUIRED, 'A valid Bitly password')
            ->addArgument('long-url', InputArgument::REQUIRED, 'The long URL to shorten')

            ->addOption('options', null, InputOption::VALUE_REQUIRED, 'An array of options used by request');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $link = new Link();
        $link->setLongUrl($input->getArgument('long-url'));

        $options = $input->getOption('options') ? json_decode($input->getOption('options'), true) : array();

        $provider = new BitlyProvider(
            new OAuthClient($input->getArgument('username'), $input->getArgument('password')),
            $options
        );

        try {
            $provider->shorten($link);

            $output->writeln(sprintf('<info>Success:</info> %s', $link->getShortUrl()));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>Failure:</error> %s', $e->getMessage()));
        }
    }
}
