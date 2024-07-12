<?php


function categoriesTree($selectCategoriesArray){


    $form = [
        "form"=>[
            "legend"=>[
                "title" =>"SHOW PRODUCT BY CATEGORIES"
            ],
            "input"=>[
                [   "type"  =>"categories",
                     "name" =>"CATEGORIES_TREE_PRODUCT",
                     "desc" => "Select the categories of product that you want to display on front office",
                    "label" => "Categories",
                    "multiple"=>true,
                    "tree" =>[
                        "id"=>"product_categories_sitefix",
                        "selected_categories" =>$selectCategoriesArray,
                        "use_checkbox"        => true
                    ]
                ],
                [
                    "type"=>"text",
                    "name"=>"NUMBER_PRODUCT_PER_CATEGORIES",
                    "label"=> "MAX NOMBRE OF PRODUCT TO SHOW"
                ],
                [
                    "type"  =>"radio",
                    "label" => "CHOOSE HOW TO DISPLAY THE PRODUCT",
                    "name"  =>"PRODUCT_FORM_CATEGORIES_LAYOUT",
                    "required" => true,
                    "values"=>[
                        [
                            "id"=> "first",
                            "label"=> "TAB",
                            "value"=>1
                        ],
                        [
                            "id" =>"second",
                            "label"=> "LIST",
                            "value"=>2
                        ],
                        [
                            "id" =>"third",
                            "label"=> "LIST WITH SLIDER",
                            "value"=>3
                        ]
                    ]
                ],
                
               
            ],
            "submit"=>[
                "title" => "save"
            ]
        ]
            ];



    return $form;
}