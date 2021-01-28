<?php
namespace Addweb\Grid\Model;
use Addweb\Grid\Api\NewsManagementInterface;
use Magento\Framework\Model\AbstractModel; 


class NewsManagement implements NewsManagementInterface
{

    protected $newsFactory;


   public function __construct(
        \Addweb\Grid\Model\ResourceModel\Grid\CollectionFactory $newsFactory
   ) {
 
       $this->newsFactory = $newsFactory;
   }

    
    /**
    * get List
    *
    * @return array
    */   
    public function getNewsList()
    {
       $collection = $this->newsFactory->create();
       $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
       $medialurl= $objectManager->get('Magento\Store\Model\StoreManagerInterface')->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        foreach($collection as $news){
            $array_get['id'] = $news['entity_id'];
            $array_get['name'] =$news['title'];
            $array_get['description'] =$news['content'];
            $array_get['image'] = $medialurl.$news['image'];
            $array_get['status'] = $news['is_active'];

             $array_tmp[]=$array_get;


        }
        $data[]=$array_tmp;
         return $data;

    }
     /**
     * GET for Post api
     * @param int $id
     * @return array
     */ 
    public function getNewsById($id)
    {

        $collection = $this->newsFactory->create();
       $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
       $medialurl= $objectManager->get('Magento\Store\Model\StoreManagerInterface')->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        foreach($collection as $news){
            if($news['entity_id'] == $id){
                $array_get['id'] = $news['entity_id'];
            $array_get['name'] =$news['title'];
            $array_get['description'] =$news['content'];
            $array_get['image'] = $medialurl.$news['image'];
            $array_get['status'] = $news['is_active'];

            }
            else{
                $array_get['message'] = 'No news found with this id';
            }

            $array_tmp=$array_get;

        }
         
         return [$array_tmp];


       
    }
}