<?php
ini_set('memory_limit', '556M');

if (!defined("_PS_VERSION_")) {
    exit;
}

class SitefixProductsCategories extends Module
{
    public function __construct()
    {
        $this->name = "sitefixProductsCategories";
        $this->tab = "front_office_features";
        $this->author = "EMANUEL ABIZIMI";
        $this->version = "0.0.1";
        $this->need_instance = 0;

        $this->ps_versions_compliancy = [
            'min' => '1.7.0.0',
            'max' => _PS_VERSION_,
        ];

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->trans('PRODUCT CATEGORIES', [], 'Modules.Newpdwroducts.Admin');
        $this->description = $this->trans('Highlight your store\'s newest products, display a block on the homepage and let the visitors know about your latest news.', [], 'Modules.Newpdwroducts.Admin');
    }
   
    public function install()
    {
        return parent::install() &&
            $this->registerHook('displayHome');
          
    }
   
    public function uninstall()
    {
        return parent::uninstall();
    }


    public function getProductFromCategories($limit)
    {
        $selectedCategories = $this->getConfigValues();
        $selectedCategories = $selectedCategories["CATEGORIES_TREE_PRODUCT"];
        $data = [];
        $id_lang = $this->context->language->id;
        $currency = $this->context->currency;
    
        foreach ($selectedCategories as $categoryId) 
        {
            $category = new Category($categoryId, $id_lang);
            $products = $category->getProducts($id_lang, 0, $limit);
    
            foreach ($products as &$product) {
                // Ajouter une valeur par défaut pour les clés manquantes
                if (!isset($product['main_variants'])) {
                    $product['main_variants'] = [];
                }
                if (!isset($product['has_discount'])) {
                    $product['has_discount'] = false;
                }
                if (!isset($product['flags'])) {
                    $product['flags'] = [];
                }
                $product['cover'] = [
                    'bySize' => [
                        'home_default' => [
                            'url' => $this->context->link->getImageLink($product['link_rewrite'], $product['id_image'], 'home_default')
                        ]
                    ]
                ];

                $product['price'] = Tools::displayPrice($product['price'], $currency);
                $product['url'] = $this->context->link->getProductLink($product['id_product']);
            }
          
            $categoryName = $category->name;
            $data[] = [
                "id" => $categoryId,
                "categoryName" => $categoryName,
                "productFromCategories" => $products
            ];
        }
        return ["PRODUCTS" => $data];
    }
    
    

    private function getConfigValues()
    {
        return [
            "CATEGORIES_TREE_PRODUCT" => json_decode(Configuration::get("CATEGORIES_TREE_PRODUCT")),
            "NUMBER_PRODUCT_PER_CATEGORIES" => Configuration::get("NUMBER_PRODUCT_PER_CATEGORIES"),
            "PRODUCT_FORM_CATEGORIES_LAYOUT" => Configuration::get("PRODUCT_FORM_CATEGORIES_LAYOUT"),
            
        ];
    }

    public function hookDisplayHome()
    {   
     
        $limitproduct = $this->getConfigValues();
        $limitproduct =(int)($limitproduct["NUMBER_PRODUCT_PER_CATEGORIES"])? : 8;
        $configValues = $this->getConfigValues();
        $products     = $this->getProductFromCategories($limitproduct);
        /**
         * @CONTROLLER URL 
         * --------
         */
        $controllerURL = Context::getContext()->link->getModuleLink($this->name, 'addToCard', ["ajax"=>true]);
        
        $this->context->smarty->assign(

            array_merge($configValues, 
                        $products,
                        ["controllerLink"=>$controllerURL]
                    ));

        return $this->display(__FILE__, 'views/templates/hook/sitefixProductsCategories.tpl');
    }

    public function renderForm()
    {
        $configFormPath     = _PS_MODULE_DIR_ . $this->name . "/src/form/categories_tree.php";
        include_once($configFormPath);

        $configValues       = $this->getConfigValues();
        $limitproduct       =(int)($configValues["NUMBER_PRODUCT_PER_CATEGORIES"])? : 8;
        $selectedCategories = $configValues["CATEGORIES_TREE_PRODUCT"];
        $form               = categoriesTree($selectedCategories);

        $helper = new HelperForm();
        $helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
        $helper->submit_action = 'SitefixCategoriesFeatured';
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->first_call = true;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name;

        $helper->tpl_vars = [
            "fields_value"=>$configValues
        ];

        return $helper->generateForm([$form]);
    }

    public function getContent()
    {
        if (Tools::isSubmit("SitefixCategoriesFeatured")) {
            $selectedCategories = Tools::getValue("CATEGORIES_TREE_PRODUCT");
            $number_per_categories = Tools::getValue("NUMBER_PRODUCT_PER_CATEGORIES");
            $layout = Tools::getValue("PRODUCT_FORM_CATEGORIES_LAYOUT");

            Configuration::updateValue("CATEGORIES_TREE_PRODUCT", json_encode($selectedCategories, true));
            Configuration::updateValue("NUMBER_PRODUCT_PER_CATEGORIES", $number_per_categories);
            Configuration::updateValue("PRODUCT_FORM_CATEGORIES_LAYOUT", $layout);
        }
      
        return $this->renderForm();
    }
}
