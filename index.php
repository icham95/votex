<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title></title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div id="app">
  <header>
    <div>
      <router-link to="/"> Votex </router-link>
    </div>
    <div>
      <router-link to="login"> Login </router-link>
      <router-link to="register"> Daftar </router-link>
    </div>
  </header>

  <div id="content">
    <router-view></router-view>
  </div>

</div>

  <script type="text/x-template" id="t-login">
    <div>
      <form @submit.prevent = "login()">
        <div class="input">
          <label for=""> Username </label>
          <input type="text" v-model="username">
        </div>
        <div class="input">  
          <label for=""> Password </label>
          <input type="text" v-model="password">
        </div>
        <div class="input">
          <button> Login </button>
        </div>
      </form>
    </div>
  </script>

  <script type="text/x-template" id="t-home">
    <div>
      home
    </div>
  </script>

  <script type="text/x-template" id="t-register">
    <div>
      <form @submit.prevent = "register()">
        <div class="input">
          <label for=""> Username </label>
          <input type="text" v-model="username">
        </div>
        <div class="input">  
          <label for=""> Password </label>
          <input type="text" v-model="password">
        </div>
        <div class="input">
          <button> Register </button>
        </div>
      </form>
    </div>
  </script>

  <script src="https://unpkg.com/vue"></script>
  <script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>
  <script src="https://unpkg.com/vuex"></script>

  <script>
    
    const Login = {
      template: '#t-login',
      data () {
        return {
          username: '',
          password: ''
        }
      },
      methods: {
        login () {
          console.log('oke')
        }
      }
    }

    const Home = {
      template: '#t-home'
    }

    const Register = {
      template: '#t-register',
      data () {
        return {
          username: '',
          password: ''
        }
      },
      methods: {
        register () {
          console.log('oke')
        }
      }
    }

    const routes = [
      { path: '/', component: Home },
      { path: '/login', component: Login },
      { path: '/register', component: Register }
    ]
    
    const router = new VueRouter({
      routes
    })

    const app = new Vue ({
      el: '#app',
      router
    })
  </script>
</body>
</html>