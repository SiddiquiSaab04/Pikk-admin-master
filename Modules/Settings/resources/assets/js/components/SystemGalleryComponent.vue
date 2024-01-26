<template>
    <div class="col-sm-6">
        <p class="mb-0">
            <label for="logo">App Logo</label>
        </p>
        <div class="form-group has-feedback position-relative">
            <input
                type="text"
                name="logo"
                :value="selectedLogo == null ? updatedLogo?.url : selectedLogo"
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
                :value="
                    selectedFavicon == null ? updatedFavicon?.url : selectedFavicon
                "
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

    <input
        type="hidden"
        name="logo"
        :value="selectedLogo == null ? updatedLogo?.url : selectedLogo"
    />
    <input
        type="hidden"
        name="favicon"
        :value="selectedLogo == null ? updatedFavicon?.url : selectedFavicon"
    />

    <ModalComponent
        v-model="showModal"
        :selected-images="selectedImages"
        :type="type"
        :index="index"
        @selected-images="handleSelectedImages"
    />
</template>

<script>
import ModalComponent from "@resources/components/ModalComponent.vue";

export default {
    components: {
        ModalComponent,
    },
    props: ["logo", "favicon"],
    data() {
        return {
            index:0,
            showModal: false,
            type: null,
            selectedLogo: this.logo,
            selectedFavicon: this.favicon,
            updatedLogo: null,
            updatedFavicon: null,
            selectedImages: [],
        };
    },
    methods: {
        handleSelectedImages(newSelection) {
            const selected = newSelection.selectedImages[0];
            selected.primary = true;

            if (newSelection.type == "logo") {
                this.updatedLogo = selected;
                this.selectedLogo = null;
            } else {
                this.updatedFavicon = selected;
                this.selectedFavicon = null;
            }

            this.showModal = false;
            this.type = null;
            this.selectedImages = [];
        },

        openModal(type) {
            this.type = type;

            if (type == "logo") {
                this.selectedImages =
                    this.selectedLogo !== null
                        ? this.selectedLogo
                        : this.updatedLogo
                        ? [this.updatedLogo]
                        : [];
            } else if (type == "favicon") {
                this.selectedImages =
                    this.selectedFavicon !== null
                        ? this.selectedFavicon
                        : this.updatedFavicon
                        ? [this.updatedFavicon]
                        : [];
            }
            this.index++;
            this.showModal = true;
        },
    },
};
</script>
