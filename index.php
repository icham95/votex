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
      <h2>Login</h2>
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

  <script type="text/x-template" id="t-feedback">
    <div>
      <div>{{ msg.type }}</div>
      <div>{{ msg.msg }}</div>
      <div v-for="item in msg.msgs">
        <div> {{ item }} </div>
      </div>
    </div>
  </script>

  <script type="text/x-template" id="t-register">
    <div>
      <h2>Register</h2>
      <form @submit.prevent = "register()">
        <div class="input">
          <label for=""> Username </label>
          <input type="text" v-model="username">
        </div>
        <div class="input">  
          <label for=""> Password </label>
          <input type="password" v-model="password">
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
    var BASEURL = 'http://localhost/pwa/vote/';
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

    const Feedback = {
      template: '#t-feedback',
      computed: {
        msg () {
          return store.state.msgFeedback
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
          let data = JSON.stringify({
            username: this.username,
            password: this.password
          })
          fetch(BASEURL + 'api/register', { 
            method: 'POST',
            body: data
          })
          .then(resp => resp.json())
          .then(data => {
            if (data.success === true) {
              store.state.msgFeedback = {
                type: 'success',
                msg: 'pendaftaran berhasil'
              }
              this.$router.push('/feedback')
            } else {
              store.state.msgFeedback = {
                type: 'failed',
                msg: 'pendaftaran gagal',
                msgs : data.msg
              }
              this.$router.push('/feedback')
            }
          })
        }
      }
    }

    const routes = [
      { path: '/', component: Home },
      { path: '/login', component: Login },
      { path: '/register', component: Register },
      { path: '/feedback', component: Feedback }
    ]
    
    const router = new VueRouter({
      routes
    })

    const store = new Vuex.Store({
      state: {
        msgFeedback: { type: null, msg: null, msgs: {} }
      }
    })

    const app = new Vue ({
      el: '#app',
      router
    })
  </script>
</body>
</html>