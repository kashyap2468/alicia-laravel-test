<template>
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Register</h5>
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
            <form action="#" class="form newtopic" @submit.prevent="register">
                <div class="modal-body">
                    <p id="text" class="text-center" style="color:green;"></p>
                    <div class="showErrorHere"></div>
                    <div class="col-md-12 p-0 mt-2">
                        <label for="name" class="control-label">Name</label>
                        <input v-model="form.name"
                               type="text"
                               class="form-control form-control-sm"
                               name="name"
                               id="name"
                        />
                        <div class="invalid-feedback" id="nameError">
                            Please enter a name.
                        </div>
                    </div>

                    <div class="col-md-12 p-0 mt-2">
                        <label for="email" class="control-label">Email</label>
                        <input v-model="form.email"
                               type="email"
                               class="form-control form-control-sm"
                               name="email"
                               id="email"
                        />
                        <div class="invalid-feedback" id="emailError">
                            Please enter a valid email.
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="col-md-12 p-0 mt-2">
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

                    <div class="col-md-12 p-0 mt-2">
                        <label for="password_confirmation" class="control-label">Confirm Password</label>
                        <input v-model="form.password_confirmation"
                               type="password"
                               class="form-control form-control-sm"
                               name="password_confirmation"
                               id="password_confirmation"
                        />
                        <div class="invalid-feedback" id="confirmpasswordError">
                            Please enter a confirm password.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Register</button>
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
</template>

<script>
    var appPath = process.env.MIX_APP_URL;
    export default {
        data() {
            return {
                visible: false,
                form: new Form({
                    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                })
            };
        },
        methods: {
            register() {
                var name = $('#name').val();
                var email = $('#email').val();
                var password = $('#password').val();
                var password_confirmation = $('#password_confirmation').val();
                var flag=0;
                $('#nameError').hide();
                $('#emailError').hide();
                $('#passwordError').hide();
                $('#confirmpasswordError').hide();
                if(name == ''){
                    $('#nameError').show();
                    flag++;
                }
                if(email == ''){
                    $('#emailError').show();
                    flag++;
                }
                else{
                    var re = /\S+@\S+\.\S+/;
                    if(re.test(email) == false){
                        $('#emailError').show();
                        flag++;
                    }
                }
                if(password == ''){
                    $('#passwordError').show();
                    flag++;
                }
                if(password_confirmation == ''){
                    $('#confirmpasswordError').html('Please enter a confirm password').show();
                    flag++;
                }
                if(password_confirmation != password){
                    $('#confirmpasswordError').html('Your password doesnt match with confirm password').show();
                    flag++;
                }
                if(flag == 0){
                    this.form.post(appPath + "/register-user").then((response) => {
                        if (response.data.success) {
                            var attr = document.getElementById("text");
                            attr.innerHTML = response.data.message;
                            this.form.reset();
                            window.location.reload();
                        } else {
                            this.$toasted.error(response.data.message);
                            // var attr = document.getElementById("text");
                            // $("#text").css('color', 'red');
                            // attr.innerHTML = response.data.message;

                        }
                    });
                }

            },
            closeModal() {
                this.visible = false;
                $("#myModal").modal("hide");
                this.visible = false;
            },
        },
    };
</script>
