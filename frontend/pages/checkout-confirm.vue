<template>
  <div id="checkout-page">
    <div class="container">
      <div class="row">
        <div class="col-md-10 checkout-info">
          <p class="message">Merci. Votre commande a été reçue.</p>

          <ul class="order-overview">
            <li>
              NUMÉRO DE COMMANDE :<strong>{{ order.code }}</strong>
            </li>
            <li>
              DATE:<strong>{{ order.last_renew }}</strong>
            </li>
            <li>
              TOTAL :<strong>{{ order.total }} €</strong>
            </li>
            <li>
              MÉTHODE DE PAIEMENT:<strong>{{ payment.name }}</strong>
            </li>
          </ul>

          <h2 class="bank-account-heading">Nos coordonnées bancaires</h2>
          <h3 class="bank-account-name">FDA Services Sarl:</h3>

          <ul class="order-overview">
            <li>BANQUE:<strong>BGL BNP Paribas S.A.</strong></li>
            <li>CODE GUICHET:<strong>BGL</strong></li>
            <li>IBAN:<strong>LU050030469353040000</strong></li>
            <li>BIC:<strong>BGLLLULL</strong></li>
          </ul>

          <h3 class="order-detail-title">Détails de la commande</h3>

          <table class="table-block">
            <thead>
              <tr>
                <th>Produit</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ product.name }} × {{ order.count }}</td>
                <td>{{ order.total }} €</td>
              </tr>
              <tr>
                <td>Sous-total :</td>
                <td>{{ order.subtotal }} €</td>
              </tr>
              <tr>
                <td>Moyen de paiement :</td>
                <td>{{ payment.name }}</td>
              </tr>
              <tr>
                <td>Total :</td>
                <td>
                  {{ order.total }} € (dont {{ Math.round(order.tax) }} € TVA)
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CheckoutConfirm',
  data() {
    return {
      order: [],
      product: [],
      payment: [],
      tax: 0
    }
  },
  mounted() {
    this.init()
    this.taxCalc()
  },
  methods: {
    async init() {
      this.order = (await this.$axios.get('/order/1')).data.order
      this.payment = (await this.$axios.get(
        '/payment-method/' + this.order.payment_method_id
      )).data.paymentMethod
      this.product = (await this.$axios.get(
        '/product/' + this.order.product_id
      )).data.product
    },
    taxCalc() {
      this.tax = Math.round(parseFloat(this.order.tax))
      console.log('tax value : ' + this.tax)
      console.log('tax : ' + this.order.tax)
      console.log('product : ' + this.product.name)
    }
  }
}
</script>

<style></style>
