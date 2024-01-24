<template>
  <div class="row">
    <div class="col-sm-12">
      <div class="">
        <label>
          Allow Payments
          <input
            type="checkbox"
            class="js-switch"
            data-switchery="true"
            style="display: none"
            @click="allowPayment = !allowPayment"
          /><span class="" ref="switchery"
            ><small class="" ref="switch"></small
          ></span>
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
            data-switchery="true"
            style="display: none"
            @click="platforms[platform].status = !platforms[platform].status"
          /><span class="" ref="switchery"
            ><small class="" ref="switch"></small
          ></span>
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
              data-switchery="true"
              style="display: none"
              @click="platforms[platform][index] = !platforms[platform][index]"
            /><span class="" ref="switchery"
              ><small class="" ref="switch"></small
            ></span>
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
        <BraintreeComponent/>
    </div>
    <div class="col-sm-4" v-if="payments.includes('paypal')">
        <PaypalComponent/>
    </div>
    <div class="col-sm-4" v-if="payments.includes('stripe')">
        <StripeComponent/>
    </div>
  </div>
</template>
<script>
import BraintreeComponent from "./BraintreeComponent.vue";
import PaypalComponent from "./PaypalComponent.vue";
import StripeComponent from "./StripeComponent.vue";

export default {
  components: {
    BraintreeComponent,
    PaypalComponent,
    StripeComponent,
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
    };
  },
  methods: {
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
              (key) => this.platforms[platform][key] === true && key != "status"
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
