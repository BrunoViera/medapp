<?php

namespace App\Command;

use App\Entity\Laboratory;
use App\Entity\Medicine;
use App\Service\MedicineService;
use App\Service\LaboratoryService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Lock\Factory;
use Symfony\Component\Lock\Store\SemaphoreStore;
use Symfony\Component\DomCrawler\Crawler;
use Exception;

class ProcessDNMACommand extends Command
{
    protected $laboratoryService;
    protected $medicineService;

    public function __construct(LaboratoryService $laboratoryService, MedicineService $medicineService)
    {
        $this->laboratoryService = $laboratoryService;
        $this->medicineService = $medicineService;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('medapp:process:dnma');
        $this->setDescription('Procesamiendo del DNMA en formato xml');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $store = new SemaphoreStore();
        $factory = new Factory($store);
        $lock = $factory->createLock($this->getName());

        if (!$lock->acquire()) {
            $io->warning('The command is being executed in another proccess.');
            return 1;
        }

        $timeStart = time();

        try {
            $filePath = sprintf('%s/../../assets/xml/DiccionarioMedicamentos.xml', __DIR__);
            $xml = simplexml_load_file($filePath, 'SimpleXMLElement', LIBXML_NOWARNING);

            $io->success('Importing Laboratories');
            $this->processLaboratory($xml->ConceptosAuxiliares->LABORATORIOS->LABORATORIO);





            $io->success('Importing Medicines - AMPS');
            $io->success('Importing Medicines - AMPPS');
            $io->success('Importing Medicines - SUSTANCIAS');
            $io->success('Importing Medicines - TFS');
            $io->success('Importing Medicines - TFGS');
            $io->success('Importing Medicines - VTMS');
            $io->success('Importing Medicines - VMPS');
            $io->success('Importing Medicines - VMPPS');



            // $io->success('Estates from file has been processed successfully!');
        } catch (Exception $e) {
            $io->error($e->getMessage());
        }


        $lock->release();
        $txt = '[%s] Finish its execution %s (%s seconds)';
        $msg = sprintf($txt, $this->getName(), date('Y-m-d H:i:s'), round(microtime(true) - $timeStart));
        $io->block($msg, null, 'fg=blue', '');

        return 0;
    }

    private function processLaboratory(\SimpleXMLElement $laboratories)
    {
        foreach ($laboratories as $item) {
            $lab = $this->laboratoryService->getByAttribute(['cnmaId' => $item->LAB_Id]);
            if (!$lab instanceof Laboratory) {
                $lab = new Laboratory();
            }
            $lab->setCnmaId((string)$item->LAB_Id);
            $lab->setName((string)$item->NOMBRE);
            $lab->setValid((string)$item->ESTADOVAL === 'V' ? true : false);
            $this->laboratoryService->save($lab);
        }
    }

    private function processMedicine($medicines, string $type)
    {
        foreach ($medicines as $item) {
            $med = new Medicine();
        }
    }
}
