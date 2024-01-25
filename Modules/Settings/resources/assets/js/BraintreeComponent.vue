<template>
    <div class="col-sm-12">
      <h3>Braintree</h3>
    </div>
  <div class="row">

    <div class="col-sm-12">
      <p class="mb-0">
        <label for="brantree_environment">Braintree Environment</label>
      </p>
      <input
        type="text"
        class="form-control"
        v-model="braintree.BRAINTREE_ENVIRONMENT"
      />
      <span class="mt-1">
        <p class="mt-1">Add Braintree Environment</p>
      </span>
    </div>

    <div class="col-sm-12">
      <p class="mb-0">
        <label for="brantree_environment">Braintree Merchant</label>
      </p>
      <input
        type="text"
        class="form-control"
        v-model="braintree.BRAINTREE_MERCHANT"
      />
      <span class="mt-1">
        <p class="mt-1">Add Braintree Merchant</p>
      </span>
    </div>

    <div class="col-sm-12">
      <p class="mb-0">
        <label for="braintree_public_key">Braintree Public Key</label>
      </p>
      <input
        type="text"
        class="form-control"
        v-model="braintree.BRAINTREE_PUBLIC_KEY"
      />
      <span class="mt-1">
        <p class="mt-1">Add Braintree Public Key</p>
      </span>
    </div>

    <div class="col-sm-12">
      <p class="mb-0">
        <label for="braintree_private_key">Braintree Private Key</label>
      </p>
      <input
        type="text"
        class="form-control"
        v-model="braintree.BRAINTREE_PRIVATE_KEY"
      />
      <span class="mt-1">
        <p class="mt-1">Add Braintree Private Key</p>
      </span>
    </div>

    <div class="col-sm-12">
      <p class="mb-0">
        <label for="braintree_merchant_account"
          >Braintree Merchant Account</label
        >
      </p>
      <input
        type="text"
        class="form-control"
        v-model="braintree.BRAINTREE_MERCHANT_ACCOUNT"
      />
      <span class="mt-1">
        <p class="mt-1">Add Braintree Merchant Account</p>
      </span>
    </div>

    <input type="hidden" name="gateway[]" :value="JSON.stringify(braintree)" />
  </div>
</template>
<script>
export default {
  data() {
    return {
      braintree: {
        BRAINTREE_ENVIRONMENT: "",
        BRAINTREE_MERCHANT: "",
        BRAINTREE_PUBLIC_KEY: "",
        BRAINTREE_PRIVATE_KEY: "",
        BRAINTREE_MERCHANT_ACCOUNT: "",
      },
    };
  },
};
</script>
