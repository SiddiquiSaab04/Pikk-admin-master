<template>
    <VaButton @click="showModal = true" round icon="add"> Add Images </VaButton>

    <VaModal
        title="Select Image(s)"
        fixed-layout
        max-height="750px"
        max-width="1700px"
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
                    v-for="(image, key) in images.data"
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
                        color="info"
                        :class="'m-0'"
                        @click="makePrimary(image)"
                    >
                        Make Primary
                    </VaButton>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["images"],
    data() {
        return {
            showModal: false,
            selectedImages: [],
        };
    },
    methods: {
        toggleSelection(image) {
            const isAlreadySelected = this.isSelect(image);

            if (isAlreadySelected) {
                this.unselect(image);
            } else {
                this.select(image);
            }
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
            hide();
        },
        makePrimary(image) {
            console.log(image);
            // return;
            this.selectedImages = this.selectedImages.map((images) => {
                if (images.id == image.id) {
                    images.primary = true;
                } else {
                    images.primary = false;
                }

                return images;
            });
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
    width: 33%;
    position: absolute;
    top: 10px;
    left: 10px;
}
</style>
