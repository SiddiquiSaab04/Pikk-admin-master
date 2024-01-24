<template>
  <div class="col-sm-12">
    <h3>Stripe</h3>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <p class="mb-0">
        <label for="stripe_environment">Stripe Environment</label>
      </p>
      <input
        type="text"
        class="form-control"
        v-model="stripe.stripe_environment"
      />
      <span class="mt-1">
        <p class="mt-1">Add Stripe Environment</p>
      </span>
    </div>

    <div class="col-sm-12">
      <p class="mb-0">
        <label for="stripe_key">Stripe Key</label>
      </p>
      <input type="text" class="form-control" v-model="stripe.stripe_key" />
      <span class="mt-1">
        <p class="mt-1">Add Stripe Key</p>
      </span>
    </div>

    <div class="col-sm-12">
      <p class="mb-0">
        <label for="stripe_secret">Stripe Secret</label>
      </p>
      <input type="text" class="form-control" v-model="stripe.stripe_secret" />
      <span class="mt-1">
        <p class="mt-1">Add Stripe Secret</p>
      </span>
    </div>
    <input type="hidden" name="stripe" :value="JSON.stringify(stripe)" />
  </div>
</template>
<script>
export default {
  data() {
    return {
      stripe: {
        stripe_environment: "",
        stripe_key: "",
        stripe_secret: "",
      },
    };
  },
};
</script>
