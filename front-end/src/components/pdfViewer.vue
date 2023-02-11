<template>
  <vue-html2pdf
    :float-layout="true"
    :enable-download="true"
    :preview-modal="true"
    :filename="'fileName'"
    pdf-format="a4"
    ref="html2Pdf"
  >
    <pdf-content @domRendered="domRendered()" slot="pdf-content" />
  </vue-html2pdf>
</template>

<script>
import VueHtml2pdf from "vue-html2pdf";

export default {
  components: {
    VueHtml2pdf,
  },
  props: {
    download: {
      type: Boolean,
      default: false,
    },
  },
  watch: {
    download: function (val) {
      if (val) {
        this.$refs.html2Pdf.download();
      }
    },
  },
};
</script>

<style lang="scss" scoped></style>
