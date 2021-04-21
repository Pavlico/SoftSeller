<?php
namespace Softserve\Seller\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Magento\Framework\App\Area;

class GenerateFile extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var \Magento\Framework\App\State
     */
    private $state;

    /**
     * @var \Softserve\Seller\Model\File\Generator
     */
    private $generator;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $urlInterface;
    
    /**
     * @param \Magento\Framework\App\State $state
     * @param \Softserve\Seller\Model\File\Generator $generator
     * @param \Magento\Framework\UrlInterface $urlInterface
     */
    public function __construct(
        \Magento\Framework\App\State $state,
        \Softserve\Seller\Model\File\Generator $generator,
        \Magento\Framework\UrlInterface $urlInterface
    ) {
        parent::__construct();
        $this->state = $state;
        $this->generator = $generator;
        $this->urlInterface = $urlInterface;
    }

    /**
    * Configures command parameters
    * @return void
    */
    protected function configure()
    {
        $this->setName('softserve:seller:generate');
        $this->addArgument(
            'limit',
            InputArgument::OPTIONAL,
            'limit sellers in file'
        );
        $this->addArgument(
            'sellers',
            InputArgument::OPTIONAL,
            'sellers code to add in file'
        );
        $this->addArgument(
            'include_reviews',
            InputArgument::OPTIONAL,
            'Add reviews to file'
        );
        parent::configure();
    }

    /**
     * @param Symfony\Component\Console\Input\InputInterface $input
     * @param Symfony\Component\Console\Output\OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->state->setAreaCode(Area::AREA_ADMINHTML);
        $limit = $input->getArguments()['limit'];
        $sellers = $input->getArguments()['sellers'];
        $includeReviews = $input->getArguments()['include_reviews'];
        $name = $this->generator->execute($limit, $sellers, $includeReviews);
        $url = $this->urlInterface->getBaseUrl();
        $output->writeln('Download raport: ' . $url . 'softserve/seller/raport?file_name=' . $name);
    }
}
