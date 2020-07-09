<?php

namespace Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Zxing\QrReader;

class QRDecode extends Command
{
    public $input;
    public $output;

    protected function configure()
    {
        $this
            ->setName("QRDecode")
            ->setDescription("The QR code command")
            ->setAliases(array("qr:decode"))
            ->addArgument("path", InputArgument::OPTIONAL, "path");
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
         $output->writeln("decode result:");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $path = $input->getArgument("path");
        if (!$path) {
            $helper = $this->getHelper("question");
            $question = new Question("Please enter the path of the QrCode:\n", "");

            $path = $helper->ask($input, $output, $question);
        }

        $qrcode = new QrReader($path);
        $text = $qrcode->text();
        $output->writeln($text);
    }

}

