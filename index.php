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

  <button @click="">
    test
  </button>

  <router-view></router-view>

</div>

  <script type="text/x-template" id="t-login">
    <div>
      login
    </div>
  </script>

  <script type="text/x-template" id="t-home">
    <div>
      home
    </div>
  </script>

  <script type="text/x-template" id="t-register">
    <div>
      register
    </div>
  </script>

  <script src="https://unpkg.com/vue"></script>
  <script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>
  <script src="https://unpkg.com/vuex"></script>

  <script>
    
    const Login = {
      template: '#t-login'
    }

    const Home = {
      template: '#t-home'
    }

    const Register = {
      template: '#t-register'
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
      router
    }).$mount('#app')
  </script>
</body>
</html>