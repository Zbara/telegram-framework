<template>
    <div class="container-tight" style="margin-top: 25vh;">
        <Form class="card card-md" @submit="submitLoginForm" :validation-schema="schema">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Авторизация</h2>
                <div class="form-group">
                    <div v-if="message" class="alert alert-danger" role="alert">
                        {{ message }}
                    </div>
                </div>
                <div class="mb-3">
                    <Field class="form-control placeholder-no-fix"  type="text" value=""
                           autocomplete="off" placeholder="E-mail" name="email"/>

                    <ErrorMessage class="error-feedback" name="email"/>
                </div>
                <div class="mb-2">
                    <div class="input-group input-group-flat">
                        <Field class="form-control placeholder-no-fix" type="password" autocomplete="off"
                               placeholder="Пароль"
                               name="password"/>
                    </div>
                    <ErrorMessage name="password" class="error-feedback" />
                </div>
                <div class="form-footer">
                    <button class="btn btn-primary w-100">Войти</button>
                </div>
            </div>
        </Form>
    </div>
</template>
<script>
import { Form, Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";

export default {
    components: {
        Form,
        Field,
        ErrorMessage,
    },
    data() {
        const schema = yup.object().shape({
            email: yup.string().required("Поле Email обязательное!"),
            password: yup.string().required("Поле Пароль обязательное!"),
        });

        return {
            headerProps: [{
                breadcrumb: false,
                textBreadcrumb: 'Авторизация',
                nameRoute: 'login',
            }],
            message: "",
            schema,
        }
    },
    mounted() {
        this.$emit('changeHeaderData', this.headerProps);
    },
    computed: {
        loggedIn() {
            return this.$store.state.auth.status.loggedIn;
        },
    },

    created() {
        if (this.loggedIn) {
            this.$router.push("/admin");
        }
    },

    methods: {
        submitLoginForm(user) {
            this.$store.dispatch("auth/login", user)
                .then(() => {
                    this.$store.dispatch('user/initUser');
                    this.$store.dispatch('menu/initApp');
                    this.$store.dispatch('settings/initApp');
                    this.$router.push({
                        name: "main",
                    });
                }, (error) => {
                    this.message =
                        (error.response &&
                            error.response.data &&
                            error.response.data.messages) ||
                        error.message ||
                        error.toString();
                }
            );
        }
    }
}

</script>
