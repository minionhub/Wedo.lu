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
                >View Order</b-link
              >
            </div>
            <div class="my-listings">
              <p>
                La commande n°<mark class="order-number">138119</mark> a été
                passée le <mark class="order-date">juin 19, 2019</mark> et est
                actuellement <mark class="order-status">Terminée</mark>.
              </p>
              <section class="order-details-part">
                <h2 class="title">Détails de la commande</h2>
                <table class="shop_table order_details">
                  <tbody>
                    <tr>
                      <th class="product-name">
                        Produit
                      </th>
                      <th class="product-total">
                        Total
                      </th>
                    </tr>
                    <tr class="order_item">
                      <th class="product-name">
                        <a href="/?post_type=product&amp;p=138118"
                          >Service comptabilité</a
                        >
                        <strong class="product-quantity">× 1</strong>
                      </th>
                      <td class="product-total">
                        <span class="amount"
                          >5.089,50&nbsp;<span class="">€</span></span
                        >
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Sous-total&nbsp;:</th>
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
                      <th scope="row">Expédition&nbsp;:</th>
                      <td>
                        Livraison gratuite
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Moyen de paiement&nbsp;:</th>
                      <td>
                        Virement bancaire
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Total&nbsp;:</th>
                      <td>
                        <span class="woocommerce-Price-amount amount"
                          >5.089,50&nbsp;<span
                            class="woocommerce-Price-currencySymbol"
                            >€</span
                          ></span
                        >
                        <small class="includes_tax"
                          >(dont.
                          <span class="woocommerce-Price-amount amount"
                            >739,50&nbsp;<span
                              class="woocommerce-Price-currencySymbol"
                              >€</span
                            ></span
                          >
                          TVA)</small
                        >
                      </td>
                    </tr>
                  </tbody>
                </table>
                <h2>
                  Abonnements apparentés
                </h2>
                <table class="shop_table my_account_orders">
                  <thead>
                    <tr>
                      <th class="order-number">
                        <span class="nobr"> Abonnement </span>
                      </th>
                      <th class="order-date">
                        <span class="nobr">Statut</span>
                      </th>
                      <th class="order-status">
                        <span class="nobr"> Prochain paiement </span>
                      </th>
                      <th class="order-total">
                        <span class="nobr">Total</span>
                      </th>
                      <th class="order-actions">&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="order">
                      <td class="subscription-id order-number" data-title="ID">
                        <a href="/my-account/view-subscription/138120/">
                          138120
                        </a>
                      </td>
                      <td
                        class="subscription-status order-status"
                        style="white-space:nowrap;"
                        data-title="Statut"
                      >
                        Actif
                      </td>
                      <td
                        class="subscription-next-payment order-date"
                        data-title="Prochain paiement"
                      >
                        juillet 19, 2019
                      </td>
                      <td
                        class="subscription-total order-total"
                        data-title="Total"
                      >
                        <span class="woocommerce-Price-amount amount"
                          >5.089,50&nbsp;<span
                            class="woocommerce-Price-currencySymbol"
                            >€</span
                          ></span
                        >&nbsp;: Mois
                      </td>
                      <td class="subscription-actions order-actions">
                        <a
                          href="/my-account/view-subscription/138120/"
                          class="button view"
                          >Affichage</a
                        >
                      </td>
                    </tr>
                  </tbody>
                </table>
                <p class="order-again">
                  <a
                    href="/cart/?order_again=138119&amp;_wpnonce=ea90ece2b8"
                    class="button"
                    >Commander une nouvelle fois</a
                  >
                </p>
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
  }
}
</script>
<style>
@import 'assets/css/my-account.css';
@import 'assets/css/my-account-custom.css';
.order_details * {
  font-size: 13px;
  font-weight: 400 !important;
}
.order_details th,
.order_details td {
  padding: 9px 0 !important;
}
p.order-again a.button {
  float: none;
  display: inline-block;
  margin-top: 15px;
  color: #fff;
  font-size: 13px;
  font-weight: 400;
  padding: 15px 40px;
  transition: all 0.2s ease;
  overflow: hidden;
  border-radius: 2px;
  line-height: 16px;
}
p.order-again a.button:hover {
  background-color: #242429 !important;
}
</style>
