<template>
  <v-container fluid fill-height>
    <v-layout align-center justify-center>
      <v-flex xs10 sm7 md5 lg3 xl2 v-if="!show_otp_box && !show_mobile_box">
        <v-form
          data-vv-scope="form1"
          :model="form1"
          lazy-validation
          @submit.prevent="submitForm('form1')"
          autocomplete="off"
          method="post"
        >
          <v-card class="elevation-18 my-4">
            <v-toolbar flat color="transparent">
              <v-toolbar-title>{{ $t("login_head") }}</v-toolbar-title>
            </v-toolbar>

            <v-card-text>
              <v-alert :value="form1.has_error" type="error" class="mb-4">
                {{ $t("login_not_recognized") }}
              </v-alert>

              <v-alert
                :value="successRegistrationRedirect"
                type="success"
                class="mb-4"
              >
                {{ $t("successfully_registered_info") }}
              </v-alert>

              <v-alert
                :value="successResetRedirect"
                type="success"
                class="mb-4"
              >
                {{ $t("reset_email_sent") }}
              </v-alert>

              <v-alert
                :value="successResetUpdateRedirect"
                type="success"
                class="mb-4"
              >
                {{ $t("password_reset_success") }}
              </v-alert>

              <v-text-field
                type="email"
                v-model="form1.email"
                data-vv-name="email"
                v-validate="'required|email'"
                :label="$t('email_address')"
                :data-vv-as="$t('email_address')"
                :error-messages="errors.collect('form1.email')"
                required
                prepend-inner-icon="email"
              ></v-text-field>

              <v-text-field
                type="password"
                v-model="form1.password"
                data-vv-name="password"
                v-validate="'required|min:8|max:24'"
                :label="$t('password')"
                :data-vv-as="$t('password')"
                :error-messages="errors.collect('form1.password')"
                required
                prepend-inner-icon="lock"
              ></v-text-field>

              <v-layout align-center justify-space-between row>
                <v-btn
                  text
                  small
                  @click="show_mobile_box = !show_mobile_box"
                  tabindex="-1"
                  color="blue lighten-3"
                  class="no-caps"
                  >{{ $t("log_in_otp") }}</v-btn
                >
                <v-btn
                  text
                  small
                  :to="{ name: 'password.email' }"
                  tabindex="-1"
                  color="grey"
                  class="no-caps"
                  >{{ $t("forgot_password") }}</v-btn
                >
              </v-layout>

              <v-switch
                name="rememberMe"
                v-model="form1.rememberMe"
                :label="$t('remember_me')"
              ></v-switch>
            </v-card-text>
            <v-card-actions>
              <v-btn
                color="primary"
                large
                block
                :loading="form1.loading"
                :disabled="form1.loading"
                type="submit"
                >{{ $t("login") }}</v-btn
              >
            </v-card-actions>
          </v-card>
          <v-btn
            @click="toRegister"
            :disabled="form1.loading"
            large
            block
            text
            class="no-caps"
            >{{ $t("or_create_a_new_account") }}
            <v-icon size="16" class="ml-1">arrow_forward</v-icon></v-btn
          >
        </v-form>
      </v-flex>

      <v-flex xs10 sm7 md5 lg3 xl2 v-if="!show_otp_box && show_mobile_box">
        <v-form
          data-vv-scope="form2"
          :model="form2"
          lazy-validation
          @submit.prevent="submitPhone('form2')"
          autocomplete="off"
          method="post"
        >
          <v-card class="elevation-18 my-4">
            <v-toolbar flat color="transparent">
              <v-icon large @click="toEmailBox"> mdi-chevron-left </v-icon>
              <v-toolbar-title>{{ $t("mobile_head") }}</v-toolbar-title>
            </v-toolbar>
            <v-card-text v-if="form2.has_error">
              <v-alert :value="form2.has_error" type="error" class="mb-4">
                {{ $t("phone_not_recognized") }}
              </v-alert>
            </v-card-text>
            <v-text-field
              v-model="form2.phoneNumber"
              data-vv-name="phoneNumber"
              v-validate="'required'"
              :label="$t('enter_phone')"
              :data-vv-as="$t('phone')"
              :error-messages="errors.collect('form2.phoneNumber')"
              required
              prepend-inner-icon="phone"
              class="pa-5"
            ></v-text-field>
            <v-card-actions>
              <v-btn
                color="primary"
                large
                block
                :loading="form2.loading"
                :disabled="form2.loading"
                type="submit"
                class="ml-0"
                >{{ $t("send_otp") }}
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-form>
      </v-flex>

      <v-flex xs10 sm7 md5 lg3 xl2 v-if="show_otp_box && !show_mobile_box">
        <v-form
          data-vv-scope="form3"
          :model="form3"
          lazy-validation
          @submit.prevent="submitOtp('form3')"
          autocomplete="off"
          method="post"
        >
          <v-card class="elevation-18 my-4">
            <v-toolbar flat color="transparent">
              <v-icon large @click="toMobileBox"> mdi-chevron-left </v-icon>
              <v-toolbar-title>{{ $t("otp_head") }}</v-toolbar-title>
            </v-toolbar>
            <v-card-text>
              <v-text-field
                v-model="form3.otp"
                data-vv-name="otp"
                v-validate="'required'"
                :label="$t('enter_your_otp')"
                :data-vv-as="$t('otp')"
                :error-messages="errors.collect('form3.otp')"
                required
                prepend-inner-icon="code"
              ></v-text-field>
              <v-btn
                :loading="form3.loading"
                :disabled="form3.loading"
                class="mr-4"
                @click="submitPhone('form2')"
                >{{ $t("resend_otp") }}</v-btn
              >
            </v-card-text>
            <v-card-actions>
              <v-btn
                color="primary"
                large
                block
                :loading="form3.loading"
                :disabled="form3.loading"
                type="submit"
                class="ml-0"
                >{{ $t("login") }}</v-btn
              >
            </v-card-actions>
          </v-card>
        </v-form>
      </v-flex>

      <div id="recaptcha-container"></div>
    </v-layout>
  </v-container>
</template>
<script>
import firebase from "firebase/app";
import "firebase/auth";
// require("../../../firebase-config");
// import { firebaseConfig } from "../../../firebase-config";

export default {
  $_veeValidate: {
    validator: "new",
  },
  data() {
    return {
      successRegistrationRedirect: false,
      successResetRedirect: false,
      successResetUpdateRedirect: false,
      show_mobile_box: false,
      show_otp_box: false,
      form1: {
        loading: false,
        email: null,
        password: null,
        rememberMe: true,
        has_error: false,
      },
      form2: {
        loading: false,
        phoneNumber: "",
        has_error: false,
        success: false,
      },
      form3: {
        loading: false,
        otp: "",
        has_error: false,
        success: false,
      },
    };
  },
  created() {
    this.successRegistrationRedirect =
      this.$route.params.successRegistrationRedirect || false;
    this.form1.email = this.$route.params.email || null;
    this.successResetRedirect =
      this.$route.params.successResetRedirect || false;
    this.successResetUpdateRedirect =
      this.$route.params.successResetUpdateRedirect || false;
  },
  mounted() {
    let firebaseScript = document.createElement("script");
    firebaseScript.setAttribute("src", "/firebase-config.js");
    document.head.appendChild(firebaseScript);
  },
  methods: {
    toRegister() {
      this.$router.push({ name: "register" });
    },
    submitPhone(formName) {
      this[formName].has_error = false;
      this[formName].loading = true;

      this.$validator.validateAll(formName).then((valid) => {
        if (valid) {
          this.initializeFirebase();
          this.sendOtp(formName, this["form2"].phoneNumber, "phoneNumber");
        } else {
          this[formName].loading = false;
          return false;
        }
      });
    },
    sendOtp(formName, phoneNumber, fieldName) {
      firebase
        .auth()
        .signInWithPhoneNumber(phoneNumber, window.recaptchaVerifier)
        .then((confirmationResult) => {
          // SMS sent. On you mobile SMS will automatically sent via Firebase
          // save with confirmationResult.confirm(code).
          window.confirmationResult = confirmationResult;

          this.show_otp_box = true;
          this.show_mobile_box = false;

          this[formName].loading = false;
        })
        .catch((error) => {
          // Error; SMS will not sent
          app.has_error = true;
          app.error = error.message;

          this.$validator.errors.add({
            field: formName + "." + fieldName,
            msg: error.message,
          });

          app.loading = false;

          this[formName].loading = false;
          return false;
        });
    },
    submitOtp(formName) {
      this[formName].has_error = false;
      this[formName].loading = true;

      this.$validator.validateAll(formName).then((valid) => {
        if (valid) {
          this.verifyOtp(this[formName].otp, formName);
        } else {
          this[formName].loading = false;
          return false;
        }
      });
    },
    verifyOtp(code, formName) {
      confirmationResult
        .confirm(code)
        .then((result) => {
          this.loginOtp("form2");
        })
        .catch((error) => {
          var msg =
            error.code == "auth/invalid-verification-code"
              ? "The SMS verification code is invalid. Please resend the verification code."
              : error.message;
          app.has_error = true;
          app.error = msg;

          this.$validator.errors.add({
            // field: formName + ".otp",
            field: formName + ".otp",
            msg: msg,
          });

          app.loading = false;

          this[formName].loading = false;
          return false;
        });
    },
    submitForm(formName) {
      this[formName].has_error = false;
      this[formName].loading = true;

      this.$validator.validateAll(formName).then((valid) => {
        if (valid) {
          this.login(formName);
        } else {
          this[formName].loading = false;
          return false;
        }
      });
    },
    login(formName) {
      // get the redirect object
      var redirect = this.$auth.redirect();
      var app = this[formName];

      this.$auth.login({
        redirect: {
          name: redirect ? redirect.from.name : "points",
          query: redirect ? redirect.from.query : null,
        },
        rememberMe: app.rememberMe,
        fetchUser: true,
        params: {
          locale: this.$i18n.locale,
          uuid: this.$store.state.app.campaign.uuid,
          email: app.email,
          password: app.password,
          remember: app.rememberMe,
        },
        success: function () {
          //this.$router.push({path: '/-/' + this.$store.state.app.wallet.slug})
        },
        error: function (res) {
          app.has_error = true;
          app.loading = false;
          app.error = res.response.data.error;
          app.errors = res.response.data.errors || {};

          this.show_otp_box = false;
          this.show_mobile_box = false;
          this["form2"].loading = false;
          this["form3"].loading = false;
        },
      });
    },
    loginOtp(formName) {
      // get the redirect object
      var redirect = this.$auth.redirect();
      var app = this[formName];

      this.$auth.login({
        redirect: {
          name: redirect ? redirect.from.name : "points",
          query: redirect ? redirect.from.query : null,
        },
        rememberMe: app.rememberMe,
        fetchUser: true,
        params: {
          locale: this.$i18n.locale,
          uuid: this.$store.state.app.campaign.uuid,
          phoneNumber: app.phoneNumber,
          remember: app.rememberMe,
        },
        success: function () {
          //this.$router.push({path: '/-/' + this.$store.state.app.wallet.slug})
        },
        error: function (res) {
          console.log("res :>> ", res);
          console.log("app :>> ", app);
          app.has_error = true;
          app.loading = false;
          app.error = res.response.data.error;
          app.errors = res.response.data.errors || {};

          this.show_otp_box = false;
          this.show_mobile_box = true;
          this["form2"].loading = false;
          this["form3"].loading = false;
        },
      });
    },
    initializeFirebase() {
      if (!firebase.apps.length) {
        firebase.initializeApp(firebaseConfig);
      }
      window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier(
        "recaptcha-container",
        {
          size: "invisible",
          callback: function (response) {
            console.log("response :>> ", response);
          },
        }
      );
    },
    toEmailBox() {
      this.show_otp_box = false;
      this.show_mobile_box = false;
    },
    toMobileBox() {
      this.show_otp_box = false;
      this.show_mobile_box = true;
    },
  },
  computed: {
    campaign() {
      return this.$store.state.app.campaign;
    },
  },
};
</script>
<style scoped>
</style>