<template>
    <VaButton @click="showModal = true" round icon="add"> Add Images </VaButton>

    <VaModal
        title="Select Image(s)"
        fixed-layout
        max-height="650px"
        max-width="1300px"
        v-model="showModal"
        ok-text="Select"
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
                    <div class="card" @click="toggleSelection(image)">
                        <img
                            :src="image.url"
                            class="card-img-top p-1"
                            :alt="image.name"
                            height="250px"
                            :class="[
                                {
                                    selected: isSelect(image),
                                },
                            ]"
                        />
                    </div>
                </div>
            </div>
        </div>
    </VaModal>
    <div class="col-md-12 col-sm-12">
        <input
            type="hidden"
            name="images"
            :value="JSON.stringify(selectedImages)"
        />
        <div class="row">
            <div
                v-for="(image, key) in selectedImages"
                :key="key"
                class="col-lg-2 col-md-3 col-4 mb-4 mt-4"
                style="cursor: pointer"
            >
                <div class="card">
                    <span class="px-3 py-2 is_primary" v-show="image.primary"
                        >primary</span
                    >
                    <VaButton
                        round
                        style="position: absolute; right: -18px; top: -18px"
                        color="danger"
                        icon="close"
                        @click="toggleSelection(image)"
                    />
                    <img
                        :src="image.url"
                        class="card-img-top p-1"
                        :alt="image.name"
                        height="250px"
                    />
                    <VaButton
                        :color="image.primary ? '#1abb9c' : 'info'"
                        :class="'m-0'"
                        @click="makePrimary(image)"
                    >
                        {{ image.primary ? "Primary" : "Make Primary" }}
                    </VaButton>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["images", "product"],
    data() {
        return {
            showModal: false,
            selectedImages: [],
        };
    },
    mounted() {
        this.initializeSelectedImages();
    },
    watch: {
        selectedImages: {
            deep: true,
            handler(newVal) {
                const hasPrimaryTrue = newVal.some(
                    (obj) => obj.primary === true || obj.edited === true
                );

                if (!hasPrimaryTrue && newVal.length > 0) {
                    newVal[0].primary = true;
                }
            },
        },
    },
    methods: {
        initializeSelectedImages() {
            if (this.product) {
                this.selectedImages = this.product.media.map((selected) => ({
                    ...selected,
                    edited: true,
                    primary: selected.pivot.primary,
                }));
            }
        },
        toggleSelection(image) {
            const isAlreadySelected = this.isSelect(image);
            isAlreadySelected ? this.unselect(image) : this.select(image);
        },

        isSelect(image) {
            return this.selectedImages.some(
                (selected) => selected.id === image.id
            );
        },

        select(image) {
            image.primary = false;
            this.selectedImages.push(image);
        },

        unselect(image) {
            const ImageToRemove = image.id;

            this.selectedImages = this.selectedImages.filter(
                (selected) => !(selected.id === ImageToRemove)
            );
        },

        beforeCancel(hide) {
            this.selectedImages = [];
            this.initializeSelectedImages();

            hide();
        },

        makePrimary(image) {
            if (image && this.selectedImages) {
                this.selectedImages.forEach((img) => {
                    const isImageMatch = img.id === image.id;
                    img.primary = isImageMatch;

                    if (img.pivot) {
                        img.pivot.primary = isImageMatch;
                    }
                });
            }
        },
    },
};
</script>
<style scoped>
.selected {
    background-color: #a4baee;
    color: #fff;
}
.is_primary {
    border: 1px solid #1abb9c;
    color: #1abb9c;
    border-radius: 30px;
    width: 47%;
    position: absolute;
    top: 10px;
    left: 10px;
}
</style>
