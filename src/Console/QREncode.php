<?php

namespace Console;

use Bridge\QR;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class QREncode extends Command
{
    public $input;
    public $output;

    protected function configure()
    {
        $this
            ->setName("QREncode")
            ->setDescription("The QR code generation command")
            ->setAliases(array("qr"))
            ->addArgument("data", InputArgument::OPTIONAL, "text data to encode");
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("generating qrcode");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $data = $input->getArgument("data");
        if (!$data) {
            $helper = $this->getHelper("question");
            $question = new Question("Please enter the text data :\n", "");

            $data = $helper->ask($input, $output, $question);
        }

        $qr = new Qr();
        $fileName = getcwd() . '/out.png';
        $qr->generate($fileName, $data);
        $output->writeln('Check out QR code here:' . $fileName);
    }

}

