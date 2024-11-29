<?php

namespace App\Command;

use App\Service\DatabaseService;
use PhpParser\Node\Expr\Cast\Int_;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[AsCommand(
    name: 'CsvToDatabase',
    description: 'Get data from csv m and records ',
)]
class CsvToDatabaseCommand extends Command
{
     /**
        * Default name
      */
      protected  static  $defaultName = 'CsvToDatabase';

    /**
     * initialize the constructor
     * @param string $projectDir
     * @param DatabaseService $databaseService
     */
        public function __construct(
            private string $projectDir,
            private DatabaseService $databaseService
        ){
            parent::__construct();
        }

    /**
     * configuration function
     * @return void
     */
        protected function configure(): void
        {
            $this
                ->setDescription('Save data from csv file to database')
                ->addArgument('markup', InputArgument::OPTIONAL, 'Percentage markup',20)

            ;
        }

    /**
     * execute command
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
            protected function execute(InputInterface $input, OutputInterface $output): int
            {
                // Get data from csv to array
                $data = $this->getCsvAsArray('data');

                // Load csv data in Database
                $this->databaseService->load($data);

                // show result message
                $io = new SymfonyStyle($input,$output);
                $io->success('Great , data saved successfully');
                return 1;

            }

            /**
             * Allows retrieval of data from csv to associative array
             * @param  string $filename
             * @return void
             */
            private function getCsvAsArray(string $filename){
                //Csv file directory
                $inputFilePath = $this->projectDir . '/public/csv/' .$filename .'.csv';

                // create serializer object
                $decoder = new Serializer([new ObjectNormalizer()],[new CsvEncoder()]);

                // Decode csv data
                $csvData = file_get_contents($inputFilePath);
                  return  $decoder->decode($csvData, 'csv');
            }
}
