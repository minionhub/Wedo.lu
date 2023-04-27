<template>
  <div id="alert2" class="cookieAlert p-0 m-0">
    <input id="alert5" type="checkbox" />
    <div id="cookieRow" class="row mx-0" style="text-align: center">
      <p
        id="content"
        class="inner my-auto ml-xl-auto col-xs-3 col-md-12 col-xl-9"
      >
        En poursuivant votre navigation sur wedo.lu, vous acceptez que des
        cookies soient utilisés afin d’améliorer votre expérience utilisateur et
        de vous offrir des contenus personnalisés.
      </p>
      <label
        id="close"
        class="my-auto mr-xl-auto mb-0 col-xs-1 col-md-12 col-xl-3"
        for="alert5"
        style="color: white; font-size: 22px;"
        @click="saveCookie()"
      >
        &#x2715;
      </label>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CookiesNotice',
  methods: {
    saveCookie() {
      this.$cookies.set('wedo-cookie', 'wedo-cookie', {
        path: '/',
        maxAge: 60 * 60 * 24 * 7
      })
      this.cookie = this.$cookies.get('wedo-cookie')
      console.log(this.cookie)
    }
  }
}
</script>

<style>
.cookieAlert {
  display: block;
  border-radius: 0;
  background-color: #333;
}

.cookieAlert .inner {
  font-size: 13px;
  line-height: 20px;
  font-weight: 400;
  font-family: 'Source Sans Pro', sans-serif;
  color: #ffffff;
}

.cookieAlert input {
  display: none;
}

.cookieAlert input:checked ~ * {
  animation-name: dismiss, hide;
  animation-duration: 100ms;
  animation-iteration-count: 1;
  animation-timing-function: ease;
  animation-fill-mode: forwards;
  animation-delay: 0s, 1ms;
}

@keyframes dismiss {
  0% {
    opacity: 1;
  }
  90%,
  100% {
    opacity: 0;
    font-size: 0;
    transform: translateY(0);
  }
}

@-moz-keyframes dismiss {
  0% {
    opacity: 1;
  }
  90%,
  100% {
    opacity: 0;
    font-size: 0;
    transform: translateY(0);
  }
}

@-webkit-keyframes dismiss {
  0% {
    opacity: 1;
  }
  90%,
  100% {
    opacity: 0;
    font-size: 0;
    transform: translateY(0);
  }
}

@keyframes hide {
  100% {
    height: 0;
    width: 0;
    overflow: hidden;
    margin: 0;
    padding: 0;
    border: 0;
  }
}

@-moz-keyframes hide {
  100% {
    height: 0;
    width: 0;
    overflow: hidden;
    margin: 0;
    padding: 0;
    border: 0;
  }
}

@-webkit-keyframes hide {
  100% {
    height: 0;
    width: 0;
    overflow: hidden;
    margin: 0;
    padding: 0;
    border: 0;
  }
}

@media (min-width: 1200px) {
  #content {
    text-align: right;
  }
  #close {
    text-align: left;
  }
}

@media (max-width: 442px) {
  #content {
    width: 90%;
    font-size: 13px;
    line-height: 16px;
    font-weight: 300;
    font-family: 'Source Sans Pro', sans-serif;
    text-align: left;
  }
  #close {
    width: 10%;
    float: left;
  }
}

#cookieRow {
  padding: 10px;
}
</style>
