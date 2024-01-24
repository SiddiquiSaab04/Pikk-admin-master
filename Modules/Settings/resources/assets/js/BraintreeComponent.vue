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
        v-model="braintree.braintree_environment"
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
        v-model="braintree.braintree_merchant"
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
        v-model="braintree.braintree_public_key"
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
        v-model="braintree.braintree_private_key"
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
        v-model="braintree.braintree_merchant_account"
      />
      <span class="mt-1">
        <p class="mt-1">Add Braintree Merchant Account</p>
      </span>
    </div>

    <input type="hidden" name="braintreee" :value="JSON.stringify(braintree)" />
  </div>
</template>
<script>
export default {
  data() {
    return {
      braintree: {
        braintree_environment: "",
        braintree_merchant: "",
        braintree_public_key: "",
        braintree_private_key: "",
        braintree_merchant_account: "",
      },
    };
  },
};
</script>
