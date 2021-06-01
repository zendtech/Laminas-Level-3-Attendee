<?php
namespace Application\Command;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputInterface,InputArgument,InputOption};
use Symfony\Component\Console\Output\OutputInterface;

class ListFiles extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:list-files';

    protected function configure(): void
    {
        // the short description shown while running "php bin/console list"
        $this->setDescription('Produces a recursive list of files starting from $path')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Usage: console app:list-files /some/dir/path [-r | --recurse] [-l VALUE | --lines=VALUE]')
            // for CLI args use ->addArgument('NAME', InputArgument:REQUIRED|OPTIONAL, 'label)
            ->addArgument('path', InputArgument::REQUIRED, 'Starting directory [default is the current dir]')
            // exmple of an option:
            ->addOption('recurse', 'r', InputOption::VALUE_NONE, 'Recurse into subdirectories (if any)')
            ->addOption('lines', 'l', InputOption::VALUE_REQUIRED, 'Number of lines in pagination');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable
        $args = $input->getArguments();
        $opts = $input->getOptions();
        $start   = $args['path'];
        $recurse = $opts['recurse'] ?? FALSE;
        $lines   = $opts['lines'] ?? 0;
        $iter = ($recurse)
              ? new RecursiveIteratorIterator(new RecursiveDirectoryIterator($start))
              : new RecursiveDirectoryIterator($start);
        $count = 0;
        foreach ($iter as $name => $obj) {
            $output->writeln($name);
            $count++;
            if ($lines && $count > $lines) {
                $count = 0;
                $pause = readline('Press ENTER to continue or "A" for All: ');
                if ($pause === 'A') $lines = 0;
            }
        }
        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}
