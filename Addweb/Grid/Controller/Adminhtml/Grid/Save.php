<?php

namespace Addweb\Grid\Controller\Adminhtml\Grid;

use Magento\Framework\App\Filesystem\DirectoryList;
    use Magento\MediaStorage\Model\File\UploaderFactory;
    use Magento\Framework\Image\AdapterFactory;
    use Magento\Framework\Filesystem;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Addweb\Grid\Model\GridFactory
     */
    var $gridFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Addweb\Grid\Model\GridFactory $gridFactory
     */

    protected $fileSystem;
protected $uploaderFactory;
protected $adapterFactory;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Addweb\Grid\Model\GridFactory $gridFactory,
        \Magento\Framework\Filesystem $fileSystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \Magento\Framework\Image\AdapterFactory $adapterFactory
    ) {
        parent::__construct($context);
        $this->gridFactory = $gridFactory;
        $this->fileSystem = $fileSystem;
     $this->adapterFactory = $adapterFactory;
     $this->uploaderFactory = $uploaderFactory;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        if (!$data) {
            $this->_redirect('grid/grid/addrow');
            return;
        }
        try {

              /* for upload image */
      
      if ((isset($_FILES['image']['name'])) && ($_FILES['image']['name'] != '') && (!isset($data['image']['delete'])))
      {
           try
           {
                $uploaderFactory = $this->uploaderFactory->create(['fileId' => 'image']);
                $uploaderFactory->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                $imageAdapter = $this->adapterFactory->create();
                $uploaderFactory->setAllowRenameFiles(true);
                $uploaderFactory->setFilesDispersion(true);
                $mediaDirectory = $this->fileSystem->getDirectoryRead(DirectoryList::MEDIA);
                $destinationPath = $mediaDirectory->getAbsolutePath('Addweb');
                $result = $uploaderFactory->save($destinationPath);

                if (!$result)
                {
                     throw new LocalizedException
                        (
                        __('File cannot be saved to path: $1', $destinationPath)
                        );
                }

                $imagePath = 'Addweb' . $result['file'];

                $data['image'] = $imagePath;

          }
          catch (\Exception $e)
          {
                $this->messageManager->addError(__("Image not Upload Pleae Try Again"));
          }
     }     
 if ((isset($data['image']['value'])))
  $data['image'] = $data['image']['value'];

            $rowData = $this->gridFactory->create();
            $rowData->setData($data);
            if (isset($data['id'])) {
                $rowData->setEntityId($data['id']);
            }
            $rowData->save();
            $this->messageManager->addSuccess(__('Row data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('grid/grid/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Addweb_Grid::save');
    }
}
