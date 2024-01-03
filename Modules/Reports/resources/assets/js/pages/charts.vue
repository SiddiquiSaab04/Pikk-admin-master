<template>
  <div class="mb-5 mx-3">
    <div class="row bg-white p-3">
        <va-date-input
        v-model="dateInput.range"
        :label="'Select Range'"
        mode="range"
        clearable
        />
    </div>
  </div>
  <div class="row">
    <div class="col-4">
      <tile-component :path="'orders-count'" :date="dateInput.range" ></tile-component>
    </div>
    <div class="col-4">
      <tile-component :path="'orders-revenue'" :date="dateInput.range"></tile-component>
    </div>
    <div class="col-4">
      <tile-component :path="'orders-profit'" :date="dateInput.range"></tile-component>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-sm-8">
      <line-component :date="dateInput.range"></line-component>
    </div>
    <div class="col-sm-4">
        <text-component :date="dateInput.range"></text-component>
    </div>
  </div>
</template>
<script>
import { ref } from "vue";
import LineComponent from "../components/LineComponent.vue";
import TileComponent from "../components/TileComponent.vue";
import TextComponent from '../components/TextComponent.vue';

import {VaDateInput } from 'vuestic-ui';
// import 'vue3-daterange-picker/dist/vue3-daterange-picker.css';

export default {
  components: {
    LineComponent,
    TileComponent,
    VaDateInput,
    TextComponent
  },
  setup() {
    const datePlusDay = (date, days) => {
      const d = new Date(date);
      d.setDate(d.getDate() + days);
      return d;
    };

    const dateInput = ref({
      range: { start: new Date(), end: datePlusDay(new Date(), 7) },
    });

    return {
      dateInput,
      datePlusDay,
    };
  },
};
</script>
