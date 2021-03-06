<?php

namespace ShopwareCli\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Read the internal CLI cache. Used for e.g. plugin repos
 *
 * Class CacheGetCommand
 * @package ShopwareCli\Command
 */
class CacheGetCommand extends BaseCommand
{
    protected $utilities;
    protected $zipDir;

    protected function configure()
    {
        $this->setName('cli:cache:get')
            ->setDescription('Read the cache')
            ->addArgument(
                'keys',
                InputArgument::IS_ARRAY,
                'One or more cache keys to read'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $keys = $input->getArgument('keys');

        if (empty($keys)) {
            foreach ($this->container->get('cache')->getKeys() as $key) {
                $output->writeln($key);
            }

            return;
        }

        foreach ($keys as $key) {
            $output->writeln("<question>{$key}</question>");
            $output->writeln($this->container->get('cache')->read($key));
        }
    }
}
