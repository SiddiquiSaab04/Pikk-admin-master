<template >
  <div class="row">
    <div class="col-sm-12 mb-4">
      <h4 class="p-4 text-center border-1">Addons</h4>
    </div>

    <div class="col-sm-4">
      <p class="mb-0">
        <label for="addon_group_id">Addon Groups</label>
      </p>
      <select v-model="selectedAddon" class="form-control">
        <option value="">-- select addons --</option>
        <option v-for="(addon, key) in allAddons" :key="key" :value="addon">
          {{ addon.name }}
        </option>
      </select>
      <span class="mt-1">
        <p class="mt-1">
          Enter addon group for the product. Product will be saved as an addon
        </p>
      </span>
    </div>
    <div class="col-sm-2">
      <p class="mb-0">
        <label for="max_selection">Max Selection</label>
      </p>
      <input
        type="number"
        class="form-control"
        name="max_selection"
        v-model="max_selection"
      />
      <span class="mt-1">
        <p class="mt-1">Max allowed selection for specific group</p>
      </span>
    </div>
    <div class="col-sm-6" v-if="Object.keys(selectedAddon).length > 1">
      <p class="mb-0">
        <label for="addon_group_id">Select Products</label>
      </p>
      <span class="mt-1">
        <p class="mt-1">Select products which you want to add as modifiers</p>
      </span>
      <div class="checkboxes" >
        <div class="form-inline row">
          <label class="reverse selectAll">
            Select All
            <input
              class="form-control mr-2"
              type="checkbox"
              checked="true"
              @click="checkAll"
            />
          </label>
        </div>
        <div
          class="form-inline row"
          v-for="(product, key) in selectedAddon.products"
          :key="key"
        >
          <label class="reverse selectAll">
            {{ product.name }}
            <input
              class="form-control mr-2"
              type="checkbox"
              :checked="product.is_selected == '1' ? true : false"
              @click="check(product.id)"
            />
          </label>
        </div>
      </div>
    </div>
    <div class="col-sm-12 mb-3">
      <div
        class="pull-right col-sm-2 d-flex justify-center align-items-center"
        id="addon_button"
      >
        <button class="btn btn-info w-100" type="button" @click="addToForm">Add</button>
      </div>
    </div>

    <div class="col-sm-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Manage Addons</h2>
          <ul class="nav navbar-right panel_toolbox justify-content-end">
            <li>
              <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Addon Name</th>
                <th>Max Selection</th>
                <th>Addon Products</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="addonBody">
                <tr v-for="(addon, key) in selectedAddons" :key="key">
                    <td>{{ key + 1 }}</td>
                    <td>{{ addon.name }}</td>
                    <td>{{ addon.max_selection }}</td>
                    <td>
                        <ul>
                            <li v-for="(product, index) in addon.products" :key="index" v-show="product.is_selected == 1">
                                {{ product.name }}
                            </li>
                        </ul>
                    </td>
                    <td>
                        <a href="javascript:void(0)" @click="deleteEntry(addon.id)">
                            <i class="fa fa-trash-o text-danger text-lg"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
          </table>
          <input type="hidden" name="addons" :value="JSON.stringify(selectedAddons)">
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["addons", "product"],
  data() {
    return {
      selectedAddons: [],
      selectedAddon: "",
      max_selection: 0,
      allAddons: [],
    };
  },
  mounted() {
    if(Object.keys(this.product).length > 0) {
        this.product.addons = this.product.addons.map((addon) => {
            addon.products = addon.addon_products.map((product) => {
                product.is_selected = 1;
                product.name = product.product.name
                return product;
            })
            addon.name = addon.modifier.name
            return addon
        })
        this.selectedAddons = this.product.addons
    }

    this.allAddons = this.addons;
    this.allAddons.map((addon) => {
      addon.products.map((product) => {
        product.is_selected = 1;
        return product;
      });
      return addon;
    });
  },
  methods: {
    checkAll() {
        this.selectedAddon.products = this.selectedAddon.products.map((product) => {
            product.is_selected = product.is_selected == 1 ? 0 : 1;
            return product
        })
    },
    check(id) {
        this.selectedAddon.products = this.selectedAddon.products.map((product) => {
            if(product.id == id) {
                product.is_selected = product.is_selected == 1 ? 0 : 1;
            }

            return product;
        })
    },
    addToForm() {
        this.selectedAddon.max_selection = this.max_selection;
        if (this.selectedAddons.find((addon) => addon.id == this.selectedAddon.id)) {
            this.selectedAddons.map((add) => {
                if (this.selectedAddon.id == add.id) {
                    add.products = this.selectedAddon.products;
                    add.max_selection = this.selectedAddon.max_selection
                }
                return add
            })
        } else {
            this.selectedAddons.push(this.selectedAddon)
        }
    },
    deleteEntry(id) {
        this.selectedAddons = this.selectedAddons.filter((addon) => addon.id != id)
    }
  },
};
</script>
