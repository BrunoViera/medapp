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
            $filePath = sprintf('%s/../../assets/xml/DiccionarioMedicamentos-2.xml', __DIR__);
            $xml = simplexml_load_file($filePath, 'SimpleXMLElement', LIBXML_NOWARNING);

            $io->text('Importing Laboratories ');
            $this->processLaboratory($xml->ConceptosAuxiliares->LABORATORIOS->LABORATORIO);
            $processed = count($xml->ConceptosAuxiliares->LABORATORIOS->LABORATORIO);
            $io->success(sprintf('Imported %s Laboratories', $processed));

            $io->text('Importing Medicines - AMPS');
            $this->processAMPS($xml->Conceptos->AMPS->AMP);
            $processed = count($xml->Conceptos->AMPS->AMP);
            $io->success(sprintf('Imported %s AMPS', $processed));

            $io->text('Importing Medicines - AMPPS');
            $this->processAMPPS($xml->Conceptos->AMPPS->AMPP);
            $processed = count($xml->Conceptos->AMPPS->AMPP);
            $io->success(sprintf('Imported %s AMPPS', $processed));

            $io->text('Importing Medicines - VTMS');
            $this->processVTMS($xml->Conceptos->VTMS->VTM);
            $processed = count($xml->Conceptos->VTMS->VTM);
            $io->success(sprintf('Imported %s VTMS', $processed));

            // $io->text('Importing Medicines - SUSTANCIAS');
            // $this->processSUSTANCIAS($xml->Conceptos->SUSTANCIAS->SUSTANCIA);
            // $processed = count($xml->Conceptos->SUSTANCIAS->SUSTANCIA);
            // $io->success(sprintf('Imported %s SUSTANCIAS', $processed));

            // $io->text('Importing Medicines - TFS');
            // $this->processTFS($xml->Conceptos->TFS->TF);
            // $processed = count($xml->Conceptos->TFS->TF);
            // $io->success(sprintf('Imported %s TFS', $processed));

            // $io->text('Importing Medicines - TFGS');
            // $this->processTFGS($xml->Conceptos->TFGS->TFG);
            // $processed = count($xml->Conceptos->TFGS->TFG);
            // $io->success(sprintf('Imported %s TFGS', $processed));

            // $io->text('Importing Medicines - VMPS');
            // $this->processVMPS($xml->Conceptos->VMPS->VMP);
            // $processed = count($xml->Conceptos->VMPS->VMP);
            // $io->success(sprintf('Imported %s VMPS', $processed));

            // $io->text('Importing Medicines - VMPPS');
            // $this->processVMPPS($xml->Conceptos->VMPPS->VMPP);
            // $processed = count($xml->Conceptos->VMPPS->VMPP);
            // $io->success(sprintf('Imported %s VMPPS', $processed));
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
        $cont = 0;
        foreach ($laboratories as $item) {
            $lab = $this->laboratoryService->getByAttribute(['cnmaId' => (int) $item->LAB_Id]);
            if (!$lab instanceof Laboratory) {
                $lab = $this->laboratoryService->create();
                $lab->setCnmaId((int)$item->LAB_Id);
            }
            $lab->setName((string)$item->NOMBRE);
            $lab->setValid((string)$item->ESTADOVAL === 'V');
            $this->laboratoryService->save($lab);
            $cont = $cont +1;
            if ($cont % 200 === 0) {
                $this->medicineService->flush();
            }
        }
        $this->medicineService->flush();
    }

    private function processAMPS($medicines)
    {
        $cont = 0;
        foreach ($medicines as $item) {
            if ($item->AMP_EstValidacion !== 'Borrador') {
                $med = $this->medicineService->getByAttribute(['cnmaId' => (int)$item->AMP_Id]);
                if (!$med instanceof Medicine) {
                    $med = $this->medicineService->create();
                    $med->setCnmaId((int)$item->AMP_Id);
                    $med->setType(MedicineService::TYPE_AMPS);
                }

                $med->setName((string)$item->AMP_DSC);
                $med->setIsValid((string)$item->AMP_Estado === 'Vigente');

                $med = $this->setLaboratory($item, $med);

                $this->medicineService->save($med);
                $cont = $cont +1;
                if ($cont % 200 === 0) {
                    $this->medicineService->flush();
                }
            }
        }
        $this->medicineService->flush();
    }

    private function processAMPPS($medicines)
    {
        $cont = 0;
        foreach ($medicines as $item) {
            if ($item->AMPP_EstValidacion !== 'Borrador') {
                $med = $this->medicineService->getByAttribute(['cnmaId' => (int)$item->AMPP_Id]);
                $related = $this->medicineService->getByAttribute(['cnmaId' => (int)$item->AMP_Id]);
                if (!$med instanceof Medicine) {
                    $med = $this->medicineService->create();
                    $med->setCnmaId((int)$item->AMPP_Id);
                    $med->setType(MedicineService::TYPE_AMPPS);
                }

                if (!$related instanceof Medicine) {
                    $med->setRelated($related);
                }

                $med->setName((string)$item->AMPP_DSC);
                $med->setIsValid((string)$item->AMPP_Estado === 'Vigente');

                $med = $this->setLaboratory($item, $med);

                $this->medicineService->save($med);
                $cont = $cont +1;
                if ($cont % 200 === 0) {
                    $this->medicineService->flush();
                }
            }
        }
        $this->medicineService->flush();
    }

    private function processVTMS($medicines)
    {
        $cont = 0;
        foreach ($medicines as $item) {
            if ($item->VTM_EstValidacion !== 'Borrador') {
                $med = $this->medicineService->getByAttribute(['cnmaId' => (int)$item->VTM_Id]);
                if (!$med instanceof Medicine) {
                    $med = $this->medicineService->create();
                    $med->setCnmaId((int)$item->VTM_Id);
                    $med->setType(MedicineService::TYPE_VTMS);
                }

                $med->setName((string)$item->VTM_DSC);
                $med->setIsValid((string)$item->VTM_Estado === 'Vigente');

                $med = $this->setLaboratory($item, $med);

                $this->medicineService->save($med);
                $cont = $cont +1;
                if ($cont % 200 === 0) {
                    $this->medicineService->flush();
                }
            }
        }
        $this->medicineService->flush();
    }


    private function processSUSTANCIAS($medicines)
    {
        foreach ($medicines as $item) {
            $med = $this->medicineService->getByAttribute(['cnmaId' => (int)$item->SUSTANCIA_ID]);
            if (!$med instanceof Medicine) {
                $med = $this->medicineService->create();
                $med->setCnmaId((int)$item->SUSTANCIA_ID);
                $med->setType(MedicineService::TYPE_SUSTANCIAS);
            }

            $med->setName((string)$item->SUSTANCIA_DSC);
            $med->setIsValid((string)$item->SUSTANCIA_Estado === 'Vigente');

            $med = $this->setLaboratory($item, $med);

            $this->medicineService->save($med);
        }
    }
    private function processTFS($medicines)
    {
        foreach ($medicines as $item) {
            $med = $this->medicineService->getByAttribute(['cnmaId' => (int)$item->TF_Id]);
            if (!$med instanceof Medicine) {
                $med = $this->medicineService->create();
                $med->setCnmaId((int)$item->TF_Id);
                $med->setType(MedicineService::TYPE_TFS);
            }

            $med->setName((string)$item->TF_DSC);
            $med->setIsValid((string)$item->TF_Estado === 'Vigente');

            $med = $this->setLaboratory($item, $med);

            $this->medicineService->save($med);
        }
    }
    private function processTFGS($medicines)
    {
        foreach ($medicines as $item) {
            $med = $this->medicineService->getByAttribute(['cnmaId' => (int)$item->TFG_Id]);
            if (!$med instanceof Medicine) {
                $med = $this->medicineService->create();
                $med->setCnmaId((int)$item->TFG_Id);
                $med->setType(MedicineService::TYPE_TFGS);
            }

            $med->setName((string)$item->TFG_DSC);
            $med->setIsValid((string)$item->TFG_Estado === 'Vigente');

            $med = $this->setLaboratory($item, $med);

            $this->medicineService->save($med);
        }
    }

    private function processVMPS($medicines)
    {
        foreach ($medicines as $item) {
            $med = $this->medicineService->getByAttribute(['cnmaId' => (int)$item->VMP_Id]);
            if (!$med instanceof Medicine) {
                $med = $this->medicineService->create();
                $med->setCnmaId((int)$item->VMP_Id);
                $med->setType(MedicineService::TYPE_VMPS);
            }

            $med->setName((string)$item->VMP_DSC);
            $med->setIsValid((string)$item->VMP_Estado === 'Vigente');

            $med = $this->setLaboratory($item, $med);

            $this->medicineService->save($med);
        }
    }
    private function processVMPPS($medicines)
    {
        foreach ($medicines as $item) {
            $med = $this->medicineService->getByAttribute(['cnmaId' => (int)$item->VMPP_Id]);
            if (!$med instanceof Medicine) {
                $med = $this->medicineService->create();
                $med->setCnmaId((int)$item->VMPP_Id);
                $med->setType(MedicineService::TYPE_VMPPS);
            }

            $med->setName((string)$item->VMPP_DSC);
            $med->setIsValid((string)$item->VMPP_Estado === 'Vigente');
            $med = $this->setLaboratory($item, $med);

            $this->medicineService->save($med);
        }
    }

    private function setLaboratory($item, $med)
    {
        if (isset($item->LABORATORIO_Id)) {
            $lab = $this->laboratoryService->getByAttribute(['cnmaId' => $item->LABORATORIO_Id]);
            if ($lab instanceof Laboratory) {
                $med->setLaboratory($lab);
            }
        }
        return $med;
    }
}
