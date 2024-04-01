<template>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>SKU</th>
                <th>Available Stock</th>
                <th>Default Quantity</th>
                <th>Is Enabled</th>
                <th>New</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <stock-data-component
                v-for="(product, key) in products"
                :key="key"
                :index="key"
                :formAction="formAction"
                :product="product"
            ></stock-data-component>
        </tbody>
    </table>
</template>

<script>
export default {
    props: ["products", "formAction"],
};
</script>
