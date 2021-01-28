<?php

namespace Addweb\Grid\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action

{

    public function execute()
    {  
       
        $this->_view->loadLayout();
        /*$this->_view->getLayout()->initMessages();
        $this->_view->getPage()->getConfig()->getTitle()->set(__('Site News'));*/
        $this->_view->renderLayout();
    }

}