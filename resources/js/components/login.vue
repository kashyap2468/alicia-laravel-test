<template>
  <div
    class="modal fade"
    id="myModal"
    tabindex="-1"
    role="dialog"
    ref="vuemodal"
  >
    <div class="modal-dialog modal-sm" role="document" v-if="!visible">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Login</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
            @click="closeModal()"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="#" class="form newtopic" @submit.prevent="login">
          <div class="modal-body">
            <p id="text" class="text-center" style="color: green;"></p>
            <div class="col-md-12 p-0">
              <label for="email" class="control-label">Email</label>
              <input v-model="form.email"
                type="text"
                class="form-control form-control-sm"
                name="email"
                id="email"
              />
              <div class="invalid-feedback" id="emailError">
                Please enter a email.
              </div>
            </div>

            <!-- Password -->
            <div class="col-md-12 mt-2 p-0">
              <label for="password" class="control-label">Password</label>
              <input v-model="form.password"
                type="password"
                class="form-control form-control-sm"
                name="password"
                id="password"
              />
              <div class="invalid-feedback" id="passwordError">
                Please enter a password.
              </div>
            </div>

            <div class="col-md-12 mt-3">
              <p>
                Not registered yet?
                <a href="#" class="text-primary" @click="goToRegister()"
                  >Register Here</a
                >
              </p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Login</button>
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
              @click="closeModal()"
            >
              Close
            </button>
          </div>
        </form>
      </div>
    </div>

    <register-component v-if="visible"></register-component>
  </div>
</template>

<script>
var appPath = process.env.MIX_APP_URL;
export default {
  data() {
    return {
      visible: false,
      form: new Form({
        csrf: document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content"),
        email: "",
        password: "",
      }),
    };
  },
  methods: {
    login() {
      var email = $("#email").val();
      var password = $("#password").val();
      var flag = 0;
      $("#emailError").hide();
      $("#passwordError").hide();
      if (email == "") {
        $("#emailError").show();
        flag++;
      } else {
        var re = /\S+@\S+\.\S+/;
        if (re.test(email) == false) {
          $("#emailError").show();
          flag++;
        }
      }
      if (password == "") {
        $("#passwordError").show();
        flag++;
      }

      if (flag == 0) {
        
        this.form.post(appPath + "/login-user").then((response) => {
          console.log(response.data);
          if (response.data.status == 200) {
              window.location.reload();
          } else {
              this.$toasted.error(response.data.message);
            // var attr = document.getElementById("text");
            // $("#text").css("color", "red");
            // attr.innerHTML = response.data.message;
          }
        });
      }
    },
    goToRegister() {
      this.visible = true;
    },
    closeModal() {
      $("#myModal").modal("hide");
      this.visible = false;
    },
    doSomethingOnHidden() {
      this.visible = false;
    },
  },
  mounted() {
    $(this.$refs.vuemodal).on("hidden.bs.modal", this.doSomethingOnHidden);
  },
};
</script>
