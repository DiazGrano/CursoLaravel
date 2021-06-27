<template>
    <!-- anchura de la mitad de la anchura de la pantalla y márgenes automáticos -->
    <div class="w-50 m-auto">
          <div class="card card-body">
              <form action>
                  <div class="form-group">
                      <label for="email">e-mail</label>
                      <input type="text" 
                      name="email" 
                      placeholder="example@example.com" 
                      class="form-control" 
                      v-model="email">
                  </div>
                  <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password"
                      name="password"
                      placeholder="********"
                      class="form-control"
                      v-model="password">
                  </div>
                  <button type="submit" class="btn btn-secondary btn-lg btn-block">Log in</button>
                  <hr/>


                  <div>
                      No account yet?
                      <router-link :to="{name:'home'}" class="font-weight-bold">Register</router-link>
                  </div>
                  
                  <div>
                      Forgotten password?
                      <router-link :to="{name:'home'}" class="font-weight-bold">Reset password</router-link>
                  </div>



              </form>
          </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            email: null,
            passworld: null
        };
    }
}
</script>