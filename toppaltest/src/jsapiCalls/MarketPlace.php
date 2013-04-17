<?php
class MarketPlace
{
    private $_selectedcategories ;

    private $_categories ;

    private $_categoriesInfo;

    private $_categoriesData;

    public function __construct($data)
    {
        $this->_selectedcategories = array();

        $this->_categories = array();

        $this->_categoriesInfo=null;

        $this->_categoriesData=$data;
    }

    /**
     * Returns all the categories for players
     */
    public function getAllCategories(){


        $categoriesTree = $this->_categoriesData;

        $categoriesTree = $categoriesTree->responseObject;
        if ($categoriesTree !== null) {
            $categoriesTree = $this->adaptFullCategoryListFromServiceBus($categoriesTree);
            $categoriesTree = json_encode($categoriesTree);
        }

        return $categoriesTree;
    }

    public function getSelectedCategories() {

        /*start, for selected categories*/
//        $clientGuid='c0e697b7-b5ea-4284-a0bf-24fe0e4cd1b6';
//        $playerGuid='f5ae83c3-3998-4bbd-9398-9250b311d1ff';
//        $json_get_player=ServicebusGetPlayer($clientGuid, $playerGuid);
        $json_get_player=ServicebusGetPlayer($_SESSION['SSMData']['clientGuid'], $_SESSION['SSMData']['playerGuid']);

        $response= json_decode($json_get_player,true);

        $selectedCategories = $response['responseObject'][0]['playerCategories'];

        if (!is_null($_SESSION['SSMData']['playerGuid'])) {
            //if (!is_null($playerGuid)) {//to fixed client and player

            $response= json_decode($json_get_player);

            $serviceBusPlayer = $response->responseObject;

            $playerCategories = $serviceBusPlayer[0]->playerCategories;
        } else {
            $playerCategories = array();
        }

        $this->_selectedcategories = $this->adaptSelectedCategoryListFromServiceBus($playerCategories);

        return $this->_selectedcategories;
    }

    private function adaptFullCategoryListFromServiceBus($serviceBusCategories) {
        usort($serviceBusCategories, function ($category1, $category2) {
            return $category1->sortOrder <= $category2->sortOrder ? -1 : 1;
        });


        $categories = array();
        foreach ($serviceBusCategories as $serviceBusCategory) {
            if ($serviceBusCategory->typeName === 'category' && ($serviceBusCategory->publicCategory === true)) {
                $childCategories = $this->adaptFullCategoryListFromServiceBus($serviceBusCategory->childCategories);
                $category = array(
                    'value' => intval($serviceBusCategory->id),
                    'label' => $serviceBusCategory->name,
                    'isPublic' => $serviceBusCategory->publicCategory === true
                );
                if (!empty($childCategories)) {
                    $category['children'] = $childCategories;
                }

                $categories[] = $category;

                $this->_categoriesInfo[$category['value']] = array('label' => $category['label']);
            }
        }

        return $categories;
    }

    private function adaptSelectedCategoryListFromServiceBus($serviceBusCategories) {
        usort($serviceBusCategories, function ($category1, $category2) {
            return $category1->sortOrder <= $category2->sortOrder ? -1 : 1;
        });
        $this->getAllCategories();

//        $isSuperAdmin = Mage::helper('account')->isSuperAdmin();
        $playerCategories = array();
        foreach ($serviceBusCategories as $selectedCategory) {
            $serviceBusCategory = $selectedCategory->category;
//            $showCategory = $isSuperAdmin || $serviceBusCategory->publicCategory === true;
            $serviceBusCategory->publicCategory === true;
//            if ($serviceBusCategory->typeName === 'category' && $showCategory) {
            if ($serviceBusCategory->typeName === 'category') {
                $category = array(
                    'value' => $serviceBusCategory->id,
                    'label' => $this->_categoriesInfo[$serviceBusCategory->id]['label'],
                    'isPublic' => $serviceBusCategory->publicCategory === true
                );

                $playerCategories[] = $category;
            }
        }

        return $playerCategories;
    }

    /**
     * Recursive method to populate $_categoriesInfo.
     * It is used when we are fetching categories from cache.
     *
     * @param array $allCategoriesArr Array from $AllCategoriesArr
     * @see getAllCategories()
     *
     */
    private function generateCategoriesInfoFromAllCategoriesArr($allCategoriesArr)
    {
        foreach ($allCategoriesArr as $category ) {
            if (!empty($category->children)) {
                $this->generateCategoriesInfoFromAllCategoriesArr($category->children);
            }
            $value = $category->value;
            $label = $category->label;

            $this->_categoriesInfo[$value] = array('label' => $label);
        }
    }



    /*begin, marketplace function */
    /*prepare keywords to send to SB*/

    function getPlayerCategoriesForDataFromParams($playerCategoryIds)
    {
        //$playerCategoryIds = $request->getParam('selected-categories-id-list', null);
        if (!empty($playerCategoryIds)) {
            $playerCategoryIdList = explode(',', $playerCategoryIds);
        } else {
            $playerCategoryIdList = array();
        }

        $order = 1;
        $result = array();
        foreach ($playerCategoryIdList as $categoryId) {
            $infoPlayerCategories = $this->obtainDataFromCategory($categoryId);
            if ($infoPlayerCategories !== null) {
                $playerCategories = array(
                    'typeName' => 'playerCategory',
                    'category' => array(
                        'typeName' => 'category',
                        'id'       => $infoPlayerCategories['categoryid'],
                        'guid'     => $infoPlayerCategories['categoryguid']
                    ),
                    'sortOrder' => $order,
                    'rankBoost' => $infoPlayerCategories['rankBoost'],
                    'id'        => $infoPlayerCategories['id'],
                    'guid'      => $infoPlayerCategories['guid']
                );

                $order ++;
                $result[] = $playerCategories;
            }
        }

        return $result;
    }

    public function searchCategoryById($serviceBusCategoryTree, $categoryId) {
        foreach ($serviceBusCategoryTree as $serviceBusCategory) {
            if ($serviceBusCategory->id === $categoryId && $serviceBusCategory->typeName === 'category') {
                return $serviceBusCategory;
            } else {
                $childCategory = $this->searchCategoryById($serviceBusCategory->childCategories, $categoryId);
                if ($childCategory !== null) {
                    return $childCategory;
                }
            }
        }

        return null;
    }

    function obtainDataFromCategory($categoryId)
    {

        $categoriesTree = $this->_categoriesData;
        $serviceBusCategoryTree = $categoriesTree->responseObject;

    //$serviceBusCategoryTree = $this->getAllCategories();//i think that is wrong, get all in mag



    $serviceBusCategory = null;
    if ($serviceBusCategoryTree !== null) {
        $serviceBusCategory = $this->searchCategoryById($serviceBusCategoryTree, $categoryId);
    }

    if ($serviceBusCategory !== null) {
        $category = array(
            'typeName'         => $serviceBusCategory->typeName,
            'categorytypeName' => $serviceBusCategory->name,
            'categoryid'       => $serviceBusCategory->id,
            'categoryguid'     => $serviceBusCategory->guid,
            'sortOrder'        => $serviceBusCategory->sortOrder,
            'rankBoost'        => $serviceBusCategory->rankBoost,
            'id'               => null,
            'guid'             => null
        );
    } else {
        $category = null;
    }

    return $category;
}

    /*begin, marketplace function */
}