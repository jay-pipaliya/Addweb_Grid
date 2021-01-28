<?php

namespace Addweb\Grid\Block;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Filesystem;

class News extends \Magento\Framework\View\Element\Template
{
      protected $_coreRegistry = null;
    protected $_collectionFactory;
    protected $_productsFactory;
    protected $_helloworldFactory;
   public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Addweb\Grid\Model\ResourceModel\Grid\CollectionFactory $newsFactory,
        \Magento\Framework\Filesystem $fileSystem,

       array $data = []
   ) {
 
       $this->_coreRegistry = $registry;
       $this->newsFactory = $newsFactory;
               $this->fileSystem = $fileSystem;

       parent::__construct($context, $data);
   }


    /**
     * Preparing global layout
     *
     * @return $this
     */
    protected function _prepareLayout() {
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('News Collection'));
        return $this;
    }

    public function getCollection()
    {
        $collection = $this->newsFactory->create();
       // $collection =$collection->addFieldToFilter('is_active', 1);
        return $collection;
    }



}