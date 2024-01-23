<template>
    <tr>
        <td>{{ index + 1 }}</td>
        <td>{{ product.name }}</td>
        <td>{{ product.sku }}</td>
        <td class="border">
            <div class="input-group input-group-sm">
                <input
                    type="number"
                    min="0"
                    v-model="available_stock"
                    class="form-control mr-2"
                    placeholder="Enter a number"
                    aria-label="Number input"
                    required
                />
            </div>
        </td>
        <td class="border">
            <div class="input-group input-group-sm">
                <input
                    type="number"
                    min="0"
                    v-model="default_quantity"
                    class="form-control mr-2"
                    placeholder="Enter a number"
                    aria-label="Number input"
                    required
                />
            </div>
        </td>
        <td class="border">
            <div class="btn-group btn-group-toggle" >
                <label
                    class="btn btn-success btn-sm"
                    :class="{ active: is_enabled == 1 }"
                >
                    <input
                        type="radio"
                        v-model="is_enabled"
                        value="1"
                        @click="handleRadioChange"
                    />
                    Yes
                </label>
                <label
                    class="btn btn-danger btn-sm"
                    :class="{ active: is_enabled == 0 }"
                >
                    <input
                        type="radio"
                        v-model="is_enabled"
                        value="0"
                        @click="handleRadioChange"
                    />
                    No
                </label>
            </div>
        </td>

        <td class="border">
            <div class="input-group-append">
                <button
                    type="button"
                    class="btn btn-primary btn-sm"
                    @click="save"
                >
                    Save
                </button>
            </div>
        </td>
    </tr>
</template>

<script>

export default {
    props: ["index", "product", "formAction"],

    data() {
        return {
            product_id: this.product.id,
            available_stock: this.product.stock
                ? this.product.stock.available_stock
                : null,
            default_quantity: this.product.stock
                ? this.product.stock.default_quantity
                : null,
            is_enabled: this.product.stock
                ? this.product.stock.is_enabled
                : null,
        };
    },
    methods: {
        save() {
            const payload = {
                product_id: this.product_id,
                available_stock: this.available_stock,
                default_quantity: this.default_quantity,
                is_enabled: this.is_enabled,
            };
            fetch(this.formAction, {
                method: "post",
                headers: {
                    "Content-Type": "application/json",
                    accept: "application/json",
                },
                body: JSON.stringify(payload),
            })
                .then((response) => response.json())
                .then((response) => {
                    this.$vaToast.init({
                        message: response.message,
                        color: "success",
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
