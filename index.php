<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Votex</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div id="app">
  <header>
    <div>
      <router-link to="/"> Votex </router-link>
    </div>
    <div>
      <router-link to="login" v-if="logged == false"> Login </router-link>
      <router-link to="register" v-if="logged == false"> Daftar </router-link>
      <router-link to="/dashboard/vote" v-if="logged == true"> Dashboard </router-link>
      <a href="" @click.prevent="logout()" v-if="logged == true"> Logout </a>
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
          <input type="password" v-model="password">
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

  <script type="text/x-template" id="t-dashboard">
    <div>
      dashboard
      <router-view></router-view>
    </div>
  </script>

  <script type="text/x-template" id="t-vote">
    <div>
      vote list
    </div>
  </script>

  <script type="text/x-template" id="t-create">
    <div>
      create
    </div>
  </script>

  <!--<script src="https://unpkg.com/vue"></script>
  <script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>
  <script src="https://unpkg.com/vuex"></script>
  <script src="https://unpkg.com/vue-ls"></script>-->

  <script src="assets/js/vue.js"></script>
  <script src="assets/js/vue-router.js"></script>
  <script src="assets/js/vuex.js"></script>
  <script src="assets/js/vue-ls.js"></script>

  <script>

    if (typeof(Storage) !== "undefined") {
        // Code for localStorage/sessionStorage.
    } else {
        // Sorry! No Web Storage support..
    }

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
          let data = JSON.stringify({
            username: this.username,
            password: this.password
          })
          fetch(BASEURL + 'api/login', {
            method: 'POST',
            body: data
          })
          .then(resp => resp.json())
          .then(data => {
            if (data.success === true) {
              Vue.ls.set('_token', data.token)
              Vue.ls.set('_logged', true)
              this.$root.logged = true
              this.$router.push('/dashboard')
            } else {
              store.state.msgFeedback = {
                type: 'failed',
                msg: '',
                msgs : data.msg
              }
              this.$router.push('/feedback')
            }
          })
        }
      },
      mounted () {
        if (Vue.ls.get('_logged') == true) {
          this.$router.push('dashboard')
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

    const Dashboard = {
      template: '#t-dashboard',
      mounted () {
        if (Vue.ls.get('_logged') !== true) {
          this.$router.push('login')
        }
        if (this.$route.path == '/dashboard') {
          this.$router.push('dashboard/vote')
        }
      }
    }
    
    const Vote = {
      template: '#t-vote'
    }

    const Create = {
      template: '#t-create'
    }

    const routes = [
      { path: '/', component: Home },
      { path: '/login', component: Login },
      { path: '/register', component: Register },
      { path: '/feedback', component: Feedback },
      { 
        path: '/dashboard', 
        component: Dashboard,
        children: [
          { path: 'vote', component: Vote },
          { path: 'create', component: Create }
        ]
      }
    ]
    
    const router = new VueRouter({
      routes
    })

    const store = new Vuex.Store({
      state: {
        msgFeedback: { type: null, msg: null, msgs: {} }
      }
    })

    var options = {
      namespace: 'votex__'
    }

    Vue.use(VueLocalStorage, options);

    const app = new Vue ({
      el: '#app',
      data () {
        return {
          logged: false
        }
      },
      router,
      methods: {
        logout () {
          Vue.ls.remove('_token')
          Vue.ls.remove('_logged')
          this.logged = false
          this.$router.push('login')
        }
      },
      mounted () {
        if (Vue.ls.get('_logged') == true) {
          this.logged = true
        } else {
          this.logged = false
        }
      }
    })
  </script>
</body>
</html>
