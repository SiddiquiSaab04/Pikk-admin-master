<template>
    <VaModal
        title="Select Image(s)"
        fixed-layout
        max-height="650px"
        max-width="1300px"
        v-model="isModalVisible"
        ok-text="Select"
        @ok="handleSelect"
        close-button
        blur
        no-outside-dismiss
        :before-cancel="beforeCancel"
    >
        <div class="col-md-12 col-sm-12">
            <div class="row">
                <div
                    v-for="(image, key) in images"
                    :key="key"
                    class="col-lg-2 col-md-3 col-4 mb-4 mt-4"
                    style="cursor: pointer"
                >
                    <div
                        class="card"
                        @click="
                            type == null
                                ? toggleSelection(image)
                                : select(image, type)
                        "
                    >
                        <img
                            :src="image.url"
                            class="card-img-top p-1"
                            :alt="image.name"
                            height="250px"
                            :class="{ selected: isSelect(image) }"
                        />
                    </div>
                </div>
            </div>
        </div>
    </VaModal>
</template>

<script>
export default {
    props: ["showModal", "selectedImages", "type", "index"],
    data() {
        return {
            isModalVisible: this.showModal,
            images: [],
            localSelectedImages: [],
        };
    },
    watch: {
        selectedImages: {
            deep: true,
            handler(newVal) {
                if (Array.isArray(newVal)) {
                    this.localSelectedImages = [...newVal];
                }
            },
        },
    },
    created() {
        this.fetchImages();
    },
    updated() {
        this.localSelectedImages = []
        this.initializeSelectedImages();
    },
    methods: {
        fetchImages() {
            fetch("/api/media/index", {
                method: "get",
                headers: {
                    "Content-Type": "application/json",
                    accept: "application/json",
                },
            })
                .then((response) => response.json())
                .then((response) => {
                    this.images = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        initializeSelectedImages() {
            console.log(typeof this.selectedImages);
            if (typeof this.selectedImages == "string") {
                let selectedimage = { url: this.selectedImages };
                selectedimage.primary = true;
                this.localSelectedImages.push(selectedimage);
            } else {
                if (this.selectedImages && this.selectedImages.length > 0) {
                    this.localSelectedImages = this.selectedImages.map(
                        (selected) => ({
                            ...selected,
                            primary: selected?.pivot?.primary,
                        })
                    );
                }
            }
        },
        toggleSelection(image) {
            const isAlreadySelected = this.isSelect(image);
            isAlreadySelected ? this.unselect(image) : this.select(image);
        },
        isSelect(image) {
            return this.localSelectedImages.some(
                (selected) => selected.id === image.id || selected.url == image.url
            );
        },

        select(image) {
            if (this.type != null && this.type != undefined) {
                this.$emit("selected-images", {
                    selectedImages: [image],
                    type: this.type,
                });
                this.localSelectedImages = [];
            } else {
                this.localSelectedImages.push(image);
            }
        },

        unselect(image) {
            this.localSelectedImages = this.localSelectedImages.filter(
                (selected) => selected.id !== image.id
            );
        },

        beforeCancel(hide) {
            this.localSelectedImages = [];
            hide();
        },
        handleSelect() {
            this.$emit("selected-images", this.localSelectedImages);
        },
    },
};
</script>

<style scoped>
.selected {
    background-color: #a4baee;
    color: #fff;
}
</style>
