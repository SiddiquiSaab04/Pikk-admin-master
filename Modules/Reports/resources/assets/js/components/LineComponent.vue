<template>
    <VueSpinner
      size="30"
      color="blue"
      :class="'absolute top-50 left-50 hourgalss z-50'"
      v-show="loading"
    />
  <div class="card rounded font-lg" :class="loading ? 'd-orders' : ''" style="min-height: 18rem">
    <div class="card-body">
      <h5 class="card-title">Orders</h5>
      <h2 class="card-text font-lg" v-if="Object.keys(data).length > 0">
        <Line :data="data" :options="options" :height="'350'" />
      </h2>
    </div>
  </div>
</template>
<script>
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
} from "chart.js";

import { Line } from "vue-chartjs";

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
);

import { VueSpinner } from "vue3-spinners";

export default {
  props: ["date"],
  mounted() {
    this.getOrderByDate(this.date.start, this.date.end);
  },
  components: {
    Line,
    VueSpinner,
  },
  watch: {
    date(newVal, oldVal) {
      this.getOrderByDate(newVal.start, newVal.end);
    },
  },
  data() {
    return {
      data: {},
      options: {
        responsive: true,
        maintainAspectRatio: false,
      },
      loading: false,
    };
  },
  methods: {
    getOrderByDate(start, end) {
      this.loading = true;
      axios
        .post("/api/6/reports/orders-by-date", {
          startDate: start.format("Y-m-d"),
          endDate: end.format("Y-m-d"),
        })
        .then((response) => {
          this.data = response.data.data;
          this.loading = false
        })
        .catch(error => {
            this.loading = false
            console.log(error)
        });
    },
  },
};
</script>
