<template>
    <div class="col-sm-6">
        <p class="mb-0">
            <label for="logo">App Logo</label>
        </p>
        <div class="form-group has-feedback position-relative">
            <input
                type="text"
                name="logo"
                :value="logo?.url"
                class="form-control"
                id="inputSuccess5"
            />
            <span
                @click="openModal('logo')"
                class="fa fa-image bg-dark text-lg form-control-feedback right"
                aria-hidden="true"
            ></span>
        </div>
        <span class="mt-1">
            <p class="mt-1">Enter Application Logo</p>
        </span>
    </div>
    <div class="col-sm-6">
        <p class="mb-0">
            <label for="favicon">Fav Icon</label>
        </p>
        <div class="form-group has-feedback position-relative">
            <input
                type="text"
                name="favicon"
                :value="favicon?.url"
                class="form-control"
                id="inputSuccess5"
            />
            <span
                @click="openModal('favicon')"
                class="fa fa-image bg-dark text-lg form-control-feedback right"
                aria-hidden="true"
            ></span>
        </div>
        <span class="mt-1">
            <p class="mt-1">Set Application Favicon</p>
        </span>
    </div>

    <input type="hidden" name="logo" :value="logo?.url" />
    <input type="hidden" name="favicon" :value="favicon?.url" />

    <ModalComponent
        v-model="showModal"
        :selected-images="selectedImages"
        :type="type"
        @selected-images="handleSelectedImages"
    />
</template>

<script>
import ModalComponent from "@resources/components/ModalComponent.vue";

export default {
    components: {
        ModalComponent,
    },
    props: [],
    data() {
        return {
            showModal: false,
            type: null,
            logo: null,
            favicon: null,
            selectedImages: [],
        };
    },
    methods: {
        handleSelectedImages(newSelection) {
            const selected = newSelection.selectedImages[0];
            if (newSelection.type == "logo") {
                this.logo = selected;
            } else {
                this.favicon = selected;
            }

            this.showModal = false;
            this.type = null
            this.selectedImages = [];
        },

        openModal(type) {
            this.type = type;

            if (type == "logo") {
                this.selectedImages = this.logo ? [this.logo] : [];
            } else if (type == "favicon") {
                this.selectedImages = this.favicon ? [this.favicon] : [];
            }

            this.showModal = true;
        },
    },
};
</script>
