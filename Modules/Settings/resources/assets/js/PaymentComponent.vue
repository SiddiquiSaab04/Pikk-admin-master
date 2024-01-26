<template>
  <div class="row">
    <div class="col-sm-12">
      <div class="">
        <label>
          Allow Payments
          <input
            type="checkbox"
            class="js-switch"
            @click="allowPayment = !allowPayment"
            v-radio-checked="allowPayment"
          />
        </label>
      </div>
    </div>
  </div>

  <div class="row mt-3" :class="{ 'opacity-5': !allowPayment }">
    <div
      class="col-sm-3"
      v-for="(platform, key) in Object.keys(platforms)"
      :key="key"
    >
      <div class="py-3">
        <label>
          {{ platform }}
          <input
            type="checkbox"
            class="js-switch"
            @click="platforms[platform].status = !platforms[platform].status"
            v-radio-checked="platforms[platform].status"
          />
        </label>
      </div>
      <div
        v-for="(payment, index) in platforms[platform]"
        :key="index"
        :class="{ 'opacity-5': !platforms[platform].status }"
      >
        <div class="mx-5 py-1" v-if="index != 'status'">
          <label>
            <input
              type="checkbox"
              class="js-switch"
              @click="platforms[platform][index] = !platforms[platform][index]"
              v-radio-checked="platforms[platform][index]"
            />
            {{ index }}
          </label>
        </div>
      </div>
    </div>
    <input
      type="hidden"
      name="payments"
      :value="JSON.stringify(selectedPlatforms)"
    />
  </div>

  <div class="row">
    <div class="col-sm-4" v-if="payments.includes('braintree')">
      <BraintreeComponent :braintree="braintree" />
    </div>
    <div class="col-sm-4" v-if="payments.includes('paypal')">
      <PaypalComponent :paypal="paypal" />
    </div>
    <div class="col-sm-4" v-if="payments.includes('stripe')">
      <StripeComponent :stripe="stripe" />
    </div>
  </div>
</template>
<script>
import BraintreeComponent from "./BraintreeComponent.vue";
import PaypalComponent from "./PaypalComponent.vue";
import StripeComponent from "./StripeComponent.vue";

export default {
  props: ["setting", "gateway"],
  components: {
    BraintreeComponent,
    PaypalComponent,
    StripeComponent,
  },
  mounted() {
    this.populateData();
  },
  data() {
    return {
      allowPayment: false,
      platforms: {
        app: {
          applepay: 0,
          braintree: 0,
          fiserv: 0,
          googlepay: 0,
          manual: 0,
          paypal: 0,
          status: 0,
          stripe: 0,
        },
        kiosk: {
          applepay: 0,
          braintree: 0,
          fiserv: 0,
          googlepay: 0,
          manual: 0,
          paypal: 0,
          status: 0,
          stripe: 0,
        },
        POS: {
          applepay: 0,
          braintree: 0,
          fiserv: 0,
          googlepay: 0,
          manual: 0,
          paypal: 0,
          status: 0,
          stripe: 0,
        },
        web: {
          applepay: 0,
          braintree: 0,
          fiserv: 0,
          googlepay: 0,
          manual: 0,
          paypal: 0,
          status: 0,
          stripe: 0,
        },
      },
      braintree: {
        BRAINTREE_ENVIRONMENT: "",
        BRAINTREE_MERCHANT: "",
        BRAINTREE_PUBLIC_KEY: "",
        BRAINTREE_PRIVATE_KEY: "",
        BRAINTREE_MERCHANT_ACCOUNT: "",
      },
      paypal: {
        PAYPAL_ENVIRONMENT: "",
        PAYPAL_CLIENT_SECRET: "",
        PAYPAL_CLIENT_ID: "",
      },
      stripe: {
        STRIPE_ENVIRONMENT: "",
        STRIPE_KEY: "",
        STRIPE_SECRET: "",
      },
    };
  },
  methods: {
    populateData() {
      if (this.setting.length > 0) {
        let settings = JSON.parse(this.setting);

        if (settings.length > 0) {
          this.allowPayment = true;
        }

        settings.map((setting) => {
          let platformData = Object.keys(setting)[0];
          setting[platformData].map((platform) => {
            this.platforms[platformData][platform] = 1;
          });
          this.platforms[platformData].status = 1;
        });
      }

      if (this.gateway.length > 0) {
        this.gateway.forEach((gateway) => {
          gateway = JSON.parse(gateway);
          if (gateway.hasOwnProperty("BRAINTREE_MERCHANT")) {
            this.braintree = gateway;
          } else if (gateway.hasOwnProperty("STRIPE_KEY")) {
            this.stripe = gateway;
          } else if (gateway.hasOwnProperty("PAYPAL_ENVIRONMENT")) {
            this.paypal = gateway;
          } else {
            // Default case
          }
        });
      }
    },
    filterTrueValues(obj) {
      return Object.keys(obj).reduce((acc, key) => {
        if (key !== "status" && key !== "applepay" && key !== "googlepay") {
          if (obj[key] === true) {
            acc[key] = true;
          }
        }
        return acc;
      }, {});
    },
  },
  computed: {
    selectedPlatforms() {
      const platforms = Object.keys(this.platforms);
      var arr = [];
      for (let i = 0; i < platforms.length; i++) {
        var platform = platforms[i];
        if (this.platforms[platform].status) {
          arr.push({
            [platform]: Object.keys(this.platforms[platform]).filter(
              (key) => this.platforms[platform][key] && key != "status"
            ),
          });
        }
      }
      return arr;
    },

    payments() {
      const selectedPayments = Object.keys(this.platforms).reduce(
        (acc, platform) => {
          // Check if status is true for the platform
          if (this.platforms[platform].status) {
            // Filter out keys with true values excluding "status," "applepay," and "googlepay"
            const platformPayments = Object.keys(
              this.platforms[platform]
            ).filter(
              (key) =>
                key !== "status" &&
                key !== "applepay" &&
                key !== "googlepay" &&
                this.platforms[platform][key]
            );

            // Add the platform name to the result array
            acc.push(platformPayments);
          }
          return acc;
        },
        []
      );
      return [...new Set([].concat(...selectedPayments))];
    },
  },
};
</script>
