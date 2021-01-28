<?php

namespace Addweb\Grid\Api;
/**
* NewsManagementInterface
*
* @category Interface
* @package  NewsManagementInterface
*/
interface NewsManagementInterface
{

    /**
    * Gets the json.
    * 
    * @api    
    * @return array
    */
    public function getNewsList();

    /**
     * GET for Post api
     * @param int $id
     * @return array
     */
    public function getNewsById($id);
   
}
