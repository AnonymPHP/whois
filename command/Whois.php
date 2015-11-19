<?php

namespace Anonym\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Anonym\Whois as Tool;

libxml_use_internal_errors(true);

class Whois extends Command
{
    public function configure()
    {
        $this
            ->setName('domain:whois')
            ->setDescription('Client for the whois directory service')
            ->addArgument(
                'domain',
                InputArgument::REQUIRED,
                'Domain'
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $domain = $input->getArgument('domain');

        try {
            $whois = new Tool($domain);
        } catch (\Exception $e) {
            return $output->writeln('<error>'.$e->getMessage().'</error>');
        }

        $datas = $whois->getDatas();

        foreach($datas as $name => $value){
            $output->writeln(sprintf('%s : %s', $name,$value));
        }
    }
}
