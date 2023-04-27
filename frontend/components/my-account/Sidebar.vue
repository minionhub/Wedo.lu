<template>
  <b-list-group class="my-account-sidebar">
    <b-list-group-item
      v-for="item in listData"
      :key="item.label"
      :href="item.href"
      :class="isActive(item) ? 'active' : null"
    >
      {{ item.label }}
    </b-list-group-item>
    <b-list-group-item href="#" @click.prevent="logout">
      Déconnexion
    </b-list-group-item>
  </b-list-group>
</template>

<script>
export default {
  data: function() {
    return {
      currentItem: '',
      listData: [
        { label: 'Tableau de bord', href: '/dashboard' },
        {
          label: 'Mon contenu',
          href: '/my-account/my-listings',
          names: ['my-account-my-listings']
        },
        {
          label: 'Mes forfaits',
          href: '/my-account/subscriptions',
          names: ['my-account-subscriptions']
        },
        {
          label: 'Mes adresses',
          href: '/my-account/addresses',
          names: ['my-account-addresses', 'my-account-addresses-address-id']
        },
        {
          label: 'Détails du compte',
          href: '/my-account/edit-account',
          names: ['my-account-edit-account']
        }
      ]
    }
  },
  mounted() {},
  methods: {
    isActive(item) {
      if (!item.names) return false
      for (let i = 0; i < item.names.length; i++) {
        if (item.names[i] === this.$route.name) return true
      }
      return false
    },
    logout() {
      this.$auth.logout()
    }
  }
}
</script>

<style>
.my-account-sidebar {
  background: #fff;
  border-right: solid 1px #e5e5e5;
  border-top: 1px solid #e5e5e5;
}

.my-account-sidebar .list-group-item {
  background-color: transparent;
  padding: 15px 45px;
  transition: all 0.3s;
  text-align: left;
  font-family: 'Open Sans', sans-serif;
  font-size: 15px;
  font-weight: 600;
  color: #5c5c68;
  border: none;
  border-bottom: solid 1px #e5e5e5;
}

.my-account-sidebar .list-group-item.active {
  color: white;
  background-color: #ffa602;
}
.my-account-sidebar .list-group-item.active:hover {
  color: white;
  background-color: #ffa602;
}
.my-account-sidebar .list-group-item:hover {
  color: #ffa602;
}

@media screen and (max-width: 992px) {
  .my-account-sidebar .list-group-item {
    /* padding: 15px 0; */
    font-size: 16px;
  }
}
</style>
