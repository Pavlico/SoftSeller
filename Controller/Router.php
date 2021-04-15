<?php
namespace Softserve\Seller\Controller;

use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RouterInterface;

/**
 * Class Router
 */
class Router implements RouterInterface
{
    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    private $actionFactory;

    /**
     * Router constructor.
     *
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     */
    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory
    ) {
        $this->actionFactory = $actionFactory;
    }

    /**
     * @param RequestInterface $request
     * @return ActionInterface|null
     */
    public function match(RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');
        $code = explode('/', $identifier);
        if ($code &&
            strpos($identifier, 'seller/' . end($code)) !== false &&
            strpos($identifier, 'all') == false &&
            strpos($identifier, 'noroute') == false
        ) {
            $request->setModuleName('softserve');
            $request->setControllerName('seller');
            $request->setActionName('details');
            $request->setParams([
                'code' => end($code),
            ]);

            return $this->actionFactory->create(Forward::class, ['request' => $request]);
        }
        return null;
    }
}
