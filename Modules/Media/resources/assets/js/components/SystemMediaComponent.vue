<template></template>
<script>
export default {
  props: ["media"],
  data() {
    return {
      isEmpty: false,
      message: "The result was not found. Please close this message or try again by clicking the refresh button.",
    };
  },
  computed: {
    filteredStocks() {
      return this.localStocks.length > 0 ? this.localStocks : this.stocks;
    },
  },
  methods: {
    changeStock(id) {
      this.value = this.$refs[id][0].value;

      axios
        .post("/api/inventory/change-stock", { id: id, value: this.value })
        .then((response) => {
          if (response.data.status == 1) {
            window.location.reload();
          } else {
            this.$toast.open({
              message: response.data.message,
              postion: "bottom",
              type: "error",
            });
          }
        })
        .catch((error) => {
          this.$toast.open({
            message: error,
            postion: "bottom",
            type: "error",
          });
        });
    },
    changeStockDefaultValue(id) {
      this.value = this.$refs["test"+id][0].value;

      axios
        .post("/api/inventory/change-stock-default-value", { id: id, value: this.value })
        .then((response) => {
          if (response.data.status == 1) {
            window.location.reload();
          } else {
            this.$toast.open({
              message: response.data.message,
              postion: "bottom",
              type: "error",
            });
          }
        })
        .catch((error) => {
          this.$toast.open({
            message: error,
            postion: "bottom",
            type: "error",
          });
        });
    },
    changeStatus(id, value) {
      axios
        .post("/api/inventory/change-status", { id: id, value: value })
        .then((response) => {
          if (response.data.status == 1) {
            window.location.reload();
          } else {
            this.$toast.open({
              message: response.data.message,
              postion: "bottom",
              type: "error",
            });
          }
        })
        .catch((error) => {
          this.$toast.open({
            message: error,
            postion: "bottom",
            type: "error",
          });
        });
    },
    search() {
      console.log(this.value);
      const result = this.stocks.filter((res) => {
        const matchedValues = Object.entries(res.product).filter(([key, val]) => {
          const stringValue = val?.toString().toLowerCase();
          const searchValue = this.searchValue.toLowerCase();
          return stringValue === searchValue;
        });
        if (matchedValues.length > 0) {
          const matchedObj = {};
          matchedValues.forEach(([key, val]) => {
            matchedObj[key] = val;
          });
          return matchedObj;
        } else {
          return false;
        }
      });
      if (result.length > 0) {
        this.localStocks = result;
      } else {
        this.isEmpty = true;
      }
    },
    reset() {
      this.isEmpty = false;
      this.localStocks = this.stocks;
    }
  },
};
</script>
