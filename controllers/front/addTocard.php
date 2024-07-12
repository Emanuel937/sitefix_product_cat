<?php


class SitefixProductsCategoriesAddToCardModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();

        // Récupérer les paramètres POST
        $id_product = (int) Tools::getValue('productID');
        $qty = (int) Tools::getValue('qty', 1);

        // Vérifiez que les paramètres sont valides
        if ($id_product && $qty) {
            // Logique pour ajouter le produit au panier
            $cart = $this->context->cart;
            $cart->updateQty($qty, $id_product);

            // Réponse JSON
            die(json_encode([
                'success' => true,
                'message' => 'Produit ajouté au panier',
                'cart' => $cart->getProducts()
            ]));
        } else {
            // Réponse JSON en cas d'échec
            die(json_encode([
                'success' => false,
                'message' => 'Paramètres invalides'
            ]));
        }
    }
}
    



