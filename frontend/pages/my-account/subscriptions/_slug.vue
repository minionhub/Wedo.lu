<template>
  <div id="my-account">
    <div class="content w-100">
      <b-container class="py-5">
        <b-row>
          <b-col md="4" lg="3" class="sidebar-wrapper">
            <Sidebar></Sidebar>
          </b-col>
          <b-col md="8" lg="9" class="subscription bg-white">
            <div class="breadcrumbs py-3">
              <b-link href="/dashboard">Dashboard</b-link>
              <span class="separator">&gt;&gt;</span>
              <b-link class="last" href="/my-account/subscriptions"
                >Abonnements</b-link
              >
            </div>
            <div class="my-listings">
              <table class="shop_table subscription_details">
                <tbody>
                  <tr>
                    <td>Statut</td>
                    <td>Actif</td>
                  </tr>
                  <tr>
                    <td>Date de début</td>
                    <td>juin 19, 2019</td>
                  </tr>
                  <tr>
                    <td>Date de dernière commande</td>
                    <td>
                      juin 19, 2019
                    </td>
                  </tr>
                  <tr>
                    <td>Date du prochain paiement</td>
                    <td>
                      juillet 19, 2019
                    </td>
                  </tr>
                  <tr>
                    <td>Actions</td>
                    <td>
                      <a
                        href="/my-account/view-subscription/138120/?subscription_id=138120&amp;change_subscription_to=cancelled&amp;_wpnonce=5ab5b5f467"
                        class="button cancel"
                        >Annuler</a
                      >
                      <a
                        href="/my-account/edit-address/livraison/?subscription=138120"
                        class="button change_address"
                        >Modifier l’adresse</a
                      >
                    </td>
                  </tr>
                </tbody>
              </table>
              <h2>Totaux des abonnements</h2>
              <table class="shop_table order_details">
                <thead>
                  <tr>
                    <td class="product-name">Produit</td>
                    <td class="product-total">Total</td>
                  </tr>
                </thead>
                <tbody>
                  <tr class="order_item">
                    <td class="product-name">
                      Service comptabilité >
                      <strong class="product-quantity">× 1</strong>
                    </td>
                    <td class="product-total">
                      <span class="woocommerce-Price-amount amount"
                        >5.089,50&nbsp;<span
                          class="woocommerce-Price-currencySymbol"
                          >€</span
                        ></span
                      >&nbsp;: Mois
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td scope="row">Sous-total&nbsp;:</td>
                    <td>
                      <span class="woocommerce-Price-amount amount"
                        >5.089,50&nbsp;<span
                          class="woocommerce-Price-currencySymbol"
                          >€</span
                        ></span
                      >
                    </td>
                  </tr>
                  <tr>
                    <td scope="row">Expédition&nbsp;:</td>
                    <td>Livraison gratuite</td>
                  </tr>
                  <tr>
                    <td scope="row">Moyen de paiement&nbsp;:</td>
                    <td>Virement bancaire</td>
                  </tr>
                  <tr>
                    <td scope="row">Total&nbsp;:</td>
                    <td>
                      <span class="woocommerce-Price-amount amount"
                        >5.089,50&nbsp;<span
                          class="woocommerce-Price-currencySymbol"
                          >€</span
                        ></span
                      >&nbsp;: Mois
                    </td>
                  </tr>
                </tfoot>
              </table>
              <h2>Commandes similaires</h2>
              <table class="shop_table my_account_orders">
                <thead>
                  <tr>
                    <th class="order-number">
                      <span class="nobr">Commande</span>
                    </th>
                    <th class="order-date"><span class="nobr">Jour</span></th>
                    <th class="order-status">
                      <span class="nobr">Statut</span>
                    </th>
                    <th class="order-total"><span class="nobr">Total</span></th>
                    <th class="order-actions">&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="order">
                    <td class="order-number" data-title="Numéro de commande :">
                      <a href="/my-account/view-order/138119/">
                        138119
                      </a>
                    </td>
                    <td class="order-date" data-title="Jour">
                      <time datetime="2019-06-19" title="1560943800"
                        >juin 19, 2019</time
                      >
                    </td>
                    <td
                      class="order-status"
                      data-title="Statut"
                      style="white-space:nowrap;"
                    >
                      Terminée
                    </td>
                    <td class="order-total" data-title="Total">
                      <span class="woocommerce-Price-amount amount"
                        >5.089,50&nbsp;<span
                          class="woocommerce-Price-currencySymbol"
                          >€</span
                        ></span
                      >
                      pour 1 article
                    </td>
                    <td class="order-actions">
                      <a
                        href="/my-account/view-order/138119/"
                        class="button view"
                        >Affichage</a
                      ><a
                        href="/my-account/view-subscription/138120/?bewpi_action=view&amp;post=138119&amp;nonce=8b76388590"
                        class="button invoice"
                        >Facture</a
                      >
                    </td>
                  </tr>
                </tbody>
              </table>
              <section class="customer-details">
                <section class="col2-set addresses">
                  <div class="col1 detail-column">
                    <h2>Adresse de facturation</h2>
                    <address>
                      Romain Schmit<br />Fédération des Artisans ASBL<br />2
                      Circuit de La Foire Internationale, 1347 Luxembourg<br />Luxembourg<br />1347
                      <p class="phone">
                        42 45 11 - 1
                      </p>
                      <p class="email">
                        info@wedo.lu
                      </p>
                    </address>
                  </div>
                  <div class="col1 detail-column">
                    <h2>Adresse de livraison</h2>
                    <address>
                      Romain Schmit<br />Fédération des Artisans ASBL<br />2
                      Circuit de La Foire Internationale, 1347 Luxembourg<br />Luxembourg<br />1347
                    </address>
                  </div>
                </section>
              </section>
            </div>
          </b-col>
        </b-row>
      </b-container>
    </div>
  </div>
</template>
<script>
import Sidebar from '~/components/my-account/Sidebar.vue'
export default {
  middleware: 'auth',
  components: {
    Sidebar
  },
  data: function() {
    return {
      title: 'Mon abonnement'
    }
  }
}
</script>
<style>
@import 'assets/css/my-account.css';
@import 'assets/css/my-account-custom.css';
</style>
