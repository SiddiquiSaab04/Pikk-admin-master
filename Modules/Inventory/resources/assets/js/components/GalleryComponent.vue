<template>
    <div>
        <!-- Button to open the modal -->
        <VaButton @click="showModal = true" round icon="add">
            Add Images
        </VaButton>

        <!-- Modal for selecting images -->
        <ModalComponent
            v-model="showModal"
            :selected-images="selectedImages"
            @selected-images="handleSelectedImages"
        />

        <!-- Display selected images -->
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
                        <span
                            class="px-3 py-2 is_primary"
                            v-show="
                                image?.primary !== undefined && image?.primary
                            "
                            >primary</span
                        >
                        <VaButton
                            round
                            style="position: absolute; right: -18px; top: -18px"
                            color="danger"
                            icon="close"
                            @click="unselect(image)"
                        />
                        <img
                            :src="image?.url"
                            class="card-img-top p-1"
                            :alt="image?.name"
                            height="250px"
                        />
                        <VaButton
                            :color="image?.primary ? '#1abb9c' : 'info'"
                            :class="'m-0'"
                            @click="makePrimary(image)"
                        >
                            {{ image?.primary ? "Primary" : "Make Primary" }}
                        </VaButton>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ModalComponent from "@resources/components/ModalComponent.vue";

export default {
    components: {
        ModalComponent,
    },
    props: ["product"],

    data() {
        return {
            showModal: false,
            selectedImages: [],
        };
    },

    watch: {
        selectedImages: {
            deep: true,
            handler(newVal) {
                if (Array.isArray(newVal)) {
                    const hasPrimaryTrue = newVal.some(
                        (obj) =>
                            obj.primary == true ||
                            (obj.pivot && obj.pivot.primary == true)
                    );

                    if (!hasPrimaryTrue && newVal.length > 0) {
                        newVal[0].primary = true;
                    }
                }
            },
        },
    },

    mounted() {
        this.initializeSelectedImages();
    },

    methods: {
        handleSelectedImages(newSelection) {
            this.selectedImages = newSelection;
        },

        initializeSelectedImages() {
            if (
                this.product &&
                this.product.media &&
                this.product.media.length > 0
            ) {
                this.selectedImages = this.product.media.map((selected) => ({
                    ...selected,
                    primary: selected.pivot.primary,
                }));
            }
        },

        unselect(image) {
            this.selectedImages = this.selectedImages.filter(
                (selected) => selected.id !== image.id
            );
        },

        makePrimary(image) {
            if (image && this.selectedImages) {
                this.selectedImages.forEach((img) => {
                    if (img.id === image.id) {
                        img.primary = true;

                        if (img.pivot) {
                            img.pivot.primary = true;
                        }
                    } else {
                        img.primary = false;

                        if (img.pivot) {
                            img.pivot.primary = false;
                        }
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
    width: 50%;
    position: absolute;
    top: 10px;
    left: 10px;
}
</style>
