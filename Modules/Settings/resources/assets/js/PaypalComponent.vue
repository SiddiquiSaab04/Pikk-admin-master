<template>
  <div class="col-sm-12">
    <h3>Paypal</h3>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <p class="mb-0">
        <label for="paypal_environment">Paypal Environment</label>
      </p>
      <input
        type="text"
        class="form-control"
        v-model="paypal.PAYPAL_ENVIRONMENT"
      />
      <span class="mt-1">
        <p class="mt-1">Add Paypal Environment</p>
      </span>
    </div>

    <div class="col-sm-12">
      <p class="mb-0">
        <label for="paypal_client_secret">Paypal Client Secret</label>
      </p>
      <input
        type="text"
        class="form-control"
        v-model="paypal.PAYPAL_CLIENT_SECRET"
      />
      <span class="mt-1">
        <p class="mt-1">Add Paypal Client Secret</p>
      </span>
    </div>

    <div class="col-sm-12">
      <p class="mb-0">
        <label for="paypal_client_id">Paypal Client ID</label>
      </p>
      <input
        type="text"
        class="form-control"
        v-model="paypal.PAYPAL_CLIENT_ID"
      />
      <span class="mt-1">
        <p class="mt-1">Add Paypal Client ID</p>
      </span>
    </div>
    <input type="hidden" name="gateway[]" :value="JSON.stringify(paypal)" />
  </div>
</template>
<script>
export default {
  data() {
    return {
      paypal: {
        PAYPAL_ENVIRONMENT: "",
        PAYPAL_CLIENT_SECRET: "",
        PAYPAL_CLIENT_ID: "",
      },
    };
  },
};
</script>
