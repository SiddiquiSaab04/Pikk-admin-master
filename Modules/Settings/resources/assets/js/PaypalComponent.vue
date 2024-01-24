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
        v-model="paypal.paypal_environment"
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
        v-model="paypal.paypal_client_secret"
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
        v-model="paypal.paypal_client_id"
      />
      <span class="mt-1">
        <p class="mt-1">Add Paypal Client ID</p>
      </span>
    </div>
    <input type="hidden" name="paypal" :value="JSON.stringify(paypal)" />
  </div>
</template>
<script>
export default {
  data() {
    return {
      paypal: {
        paypal_environment: "",
        paypal_client_secret: "",
        paypal_client_id: "",
      },
    };
  },
};
</script>
