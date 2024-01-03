<template>
  <VueSpinner
    size="20"
    color="blue"
    :class="'absolute top-50 left-50 hourgalss z-50'"
    v-show="loading"
  />
  <div
    class="card rounded font-lg"
    :class="loading ? 'd-orders' : ''"
    style="min-height: 100%"
  >
    <div class="card-body">
      <h5 class="card-title">Platform Percentage</h5>
      <h2 class="card-text font-bold" v-for="(platform, key) in data" :key="key">
        <span class="text-capitalize font-bold"> {{ key }}</span>
        <span class="float-right"> {{ platform }}%</span>
      </h2>
    </div>
  </div>
</template>
<script>
import { VueSpinner } from "vue3-spinners";
export default {
  props: ["date"],
  components: {
    VueSpinner,
  },
  data() {
    return {
      data: {},
      loading: false,
    };
  },
  watch: {
    date(newVal, oldVal) {
      this.getData(newVal.start, newVal.end);
    },
  },
  mounted() {
    this.getData(this.date.start, this.date.end);
  },
  methods: {
    getData(start, end) {
      this.loading = true;
      axios
        .post("/api/6/reports/orders-by-platform", {
          startDate: start.format("Y-m-d"),
          endDate: end.format("Y-m-d")
        })
        .then((response) => {
          this.loading = false;
          this.data = response.data.data;
        })
        .catch((error) => {
          console.log(error);
          this.loading = false;
        });
    },
  },
};
</script>
