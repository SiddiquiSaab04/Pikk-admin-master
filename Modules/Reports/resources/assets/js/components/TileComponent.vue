<template>
  <div class="card rounded font-lg" style="min-height: 8rem">
    <div class="card-body">
      <h5 class="card-title">{{ data.message }}</h5>
      <h2 class="card-text font-lg">
        {{ data.data }}
      </h2>
    </div>
  </div>
</template>
<script>
export default {
  props: ["path"],
  data() {
    return {
      data: {},
    };
  },
  mounted() {
    this.getData();
  },
  methods: {
    getData() {
      axios.get("/api/6/reports/" + this.path).then((response) => {
        this.data = response.data
      });
    },
  },
};
</script>
